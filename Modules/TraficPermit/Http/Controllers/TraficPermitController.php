<?php

namespace Modules\TraficPermit\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\TraficPermit\Enums\PermitOrderStatus;
use Modules\TraficPermit\Enums\TraficPermitStatus;
use Modules\TraficPermit\Enums\TransactionType;
use Modules\TraficPermit\Models\PermitOrder;
use Modules\TraficPermit\Models\Repository;
use Modules\TraficPermit\Models\TraficPermit;
use Modules\TraficPermit\Models\Transaction;
use Rezahmady\SettingOperation\Setting;

class TraficPermitController extends Controller
{
    public function all(Request $request) {

        $search_term = $request->input('q');

        $options = TraficPermit::query();

        if ($search_term)
        {
            $results = $options->where('serial_number', 'LIKE', '%'.$search_term.'%')->paginate(10);
        }
        else
        {
            $results = $options->paginate(10);
        }

        return $results;
    }

    public function forprint(Request $request) {

        $search_term = $request->input('q');

        $form = backpack_form_input();

        // if no country_id and types has been selected, show no options
        if (!isset($form['country_id']) or !isset($form['types'])) {
            return [];
        }

        $types = array_map('intval', (array) json_decode($form['types'], true));
        $types = array_values(array_filter($types));
        sort($types);
        $n = count($types);

        if ($n === 0) {
            return [];
        }

        // Filter repositories first (~750 rows) instead of morph-matching every permit (~34k)
        $repositoryIds = Repository::query()
            ->where('country_id', $form['country_id'])
            ->where('status', 1)
            ->where('end_date', '>=', Carbon::today()->toDateString())
            ->whereHas('types', fn ($q) => $q->whereIn('trafic_permit_types.id', $types), '=', $n)
            ->whereDoesntHave('types', fn ($q) => $q->whereNotIn('trafic_permit_types.id', $types))
            ->pluck('id');

        if ($repositoryIds->isEmpty()) {
            return [];
        }

        $options = TraficPermit::query()
            ->without(['exports', 'types', 'repository'])
            ->select(['id', 'serial_number', 'repository_id', 'status'])
            ->where('status', TraficPermitStatus::Active->value)
            ->whereIn('repository_id', $repositoryIds);

        if ($search_term) {
            $options->where('serial_number', 'LIKE', '%'.$search_term.'%');
        }

        $results = $options->simplePaginate(10);

        $results->getCollection()->each(fn ($permit) => $permit->setAppends([]));

        return $results;
    }

    public function print(Request $request) {

        if(! $request->traficpermit) {
            return response()->json([
                'status' => false,
                'index' => $request->index,
                'message' => trans('traficpermit::traficpermit.export_form_required_trafic_permit'),
            ]);
        }

        try {
            $export = null;

            DB::transaction(function () use ($request, &$export) {
                $traficpermit = TraficPermit::lockForUpdate()->findOrFail($request->traficpermit);

                if ($traficpermit->status !== TraficPermitStatus::Active->value) {
                    throw new \RuntimeException('invalid_trafic_permit');
                }

                // Prefer existing finalized export for this pair (idempotent print after race)
                $existing = $traficpermit->allExports()
                    ->where('permit_order_id', $request->permit_order_id)
                    ->where('status', 1)
                    ->first();

                if ($existing) {
                    $export = $existing;
                    return;
                }

                $export = $traficpermit->allExports()->updateOrCreate(
                    ['permit_order_id' => $request->permit_order_id, 'status' => 0],
                    ['date' => new Carbon(), 'status' => 0]
                );
            }, 3);
        } catch (\RuntimeException $e) {
            if ($e->getMessage() === 'invalid_trafic_permit') {
                return response()->json([
                    'status' => false,
                    'index' => $request->index,
                    'message' => trans('traficpermit::traficpermit.export_form_invalid_trafic_permit'),
                ]);
            }
            throw $e;
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'index' => $request->index,
                'message' => trans('traficpermit::traficpermit.export_form_invalid_trafic_permit'),
            ]);
        }

        return response()->json([
            'status' => true,
            'index' => $request->index,
            'message' => trans('traficpermit::traficpermit.export_form_successfull_print'),
            'link' => backpack_url("/permit-order/$request->permit_order_id/permitexport/$export->id/print")
        ]);

    }

    public function report(Request $request) {

        if(! $request->traficpermit) {
            return response()->json([
                'status' => false,
                'index' => $request->index,
                'message' => trans('traficpermit::traficpermit.export_form_required_trafic_permit'),
            ]);
        }

        if(! $request->price) {
            return response()->json([
                'status' => false,
                'index' => $request->index,
                'message' => trans('traficpermit::traficpermit.export_form_required_price'),
            ]);
        }

        $amount = (int) $request->price * (1 + Setting::get('transactions.tax', 0)/100 );

        try {
            DB::transaction(function () use ($request, $amount) {
                $traficpermit = TraficPermit::lockForUpdate()->findOrFail($request->traficpermit);

                // Already finalized for this order+permit — idempotent success
                $existing = $traficpermit->allExports()
                    ->where('permit_order_id', $request->permit_order_id)
                    ->where('status', 1)
                    ->first();

                if ($existing) {
                    return;
                }

                if ($traficpermit->status !== TraficPermitStatus::Active->value) {
                    throw new \RuntimeException('invalid_trafic_permit');
                }

                $export = $traficpermit->allExports()->updateOrCreate(
                    ['permit_order_id' => $request->permit_order_id, 'status' => 0],
                    ['status' => 1, 'date' => Carbon::now(), 'amount' => $amount ]
                );

                // Only charge when this finalize created/updated the export to status=1
                $alreadyCharged = Transaction::where('trafic_permit_export_id', $export->id)
                    ->where('status', 1)
                    ->where('type', TransactionType::Withdraw->value)
                    ->exists();

                if (! $alreadyCharged) {
                    Transaction::create([
                        'unity_id' => $export->order->unity_id,
                        'type' => TransactionType::Withdraw,
                        'amount' => $amount,
                        'trafic_permit_export_id' => $export->id
                    ]);
                }

                $traficpermit->update(['status' => TraficPermitStatus::Issued->value]);

                $orders = json_decode($request->orders, false);

                if (sizeof($orders) === $export->order->traficPermits()->wherePivot('status', 1)->count()) {
                    $export->order->update(['status' => PermitOrderStatus::Completed->value]);
                } else {
                    $export->order->update(['status' => PermitOrderStatus::Issuing->value]);
                }
            }, 3);
        } catch (\RuntimeException $e) {
            if ($e->getMessage() === 'invalid_trafic_permit') {
                return response()->json([
                    'status' => false,
                    'index' => $request->index,
                    'message' => trans('traficpermit::traficpermit.export_form_invalid_trafic_permit'),
                ]);
            }
            throw $e;
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'index' => $request->index,
                'message' => trans('traficpermit::traficpermit.export_form_invalid_trafic_permit'),
            ]);
        }

        return response()->json([
            'status' => true,
            'index' => $request->index,
            'message' => trans('traficpermit::traficpermit.export_successfull'),
        ]);
    }

    public function remove(Request $request) {

        $orders = json_decode($request->orders, false);

        if (($key = array_search($request->order, $orders)) !== false) {
            unset($orders[$key]);
        }

        $order = PermitOrder::findOrFail($request->permit_order_id);

        DB::transaction(function () use ($request, $orders, $order) {

            $order->update([
                'extras' => ['orders' => json_encode(array_values($orders)) ]
            ]);

            $order->traficPermits()->wherePivot('status', 1)->count();

            if(sizeof($orders) === $order->traficPermits()->wherePivot('status', 1)->count()) {
                $order->update(['status' => PermitOrderStatus::Completed->value]);
            } else {
                $order->update(['status' => PermitOrderStatus::Issuing->value]);
            }

        }, 3);

        return response()->json([
            'status' => true,
            'index' =>  $request->index,
            'message' => trans('traficpermit::traficpermit.export_delete_successfull'),
        ]);
    }
}

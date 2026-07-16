<?php

namespace Modules\Unity\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Unity\Models\Truck;

class TruckOrderController extends Controller
{
    public function index(Request $request)
    {
        $search_term = $request->input('q'); // the search term in the select2 input

        // NOTE: this is a Backpack helper that parses your form input into an usable array.
        // you still have the original request as `request('form')`
        $form = backpack_form_input();

        $options = Truck::query();

        // if no category has been selected, show no options
        if (!isset($form['unity_id'])) {
            return [];
        }
        
        // return response()->json($options->select(DB::raw('*'))
        //         ->from('permit_orders')
        //         ->whereNull('permit_orders.deleted_at')
        //         ->whereColumn('permit_orders.truck_id', 'trucks.id')
        //         ->join('permit_order_trafic_permit', 'permit_order_trafic_permit.permit_order_id', '=', 'permit_orders.id')
        //         ->where('permit_order_trafic_permit.status', 1)
        //         ->whereNull('permit_order_trafic_permit.get_carcasses_at')
        //         ->get());

        // لاشه تحویل داده نشده نداشته باشد
        $options->whereNotExists(function ($query) {
            $query->select(DB::raw('*'))
                ->from('permit_orders')
                ->whereNull('permit_orders.deleted_at')
                ->whereColumn('permit_orders.truck_id', 'trucks.id')
                ->join('permit_order_trafic_permit', 'permit_order_trafic_permit.permit_order_id', '=', 'permit_orders.id')
                ->where('permit_order_trafic_permit.status', 1)
                ->whereNull('permit_order_trafic_permit.get_carcasses_at');
            // ->join('trafic_permits', 'trafic_permits.id', '=', 'permit_order_trafic_permit.trafic_permit_id')
            // ->where('trafic_permits.status', 'issued');
        });

        //درخواست باز نداشته باشد
        $options->whereNotExists(function ($query) {
            $query->select(DB::raw('*'))
                ->from('permit_orders')
                ->whereNull('permit_orders.deleted_at')
                ->whereColumn('permit_orders.truck_id', 'trucks.id')
                ->whereIn('permit_orders.status', ['pending', 'issuing']);
        });

        // if a category has been selected, only show articles in that category
        // if(backpack_user()->can('truck manage all')) {
        if ($form['unity_id']) {
            $options = $options->where('unity_id', $form['unity_id']);
        }
        // } elseif(!backpack_user()->can('truck manage all') and backpack_user()->unity) {
        //     $options = $options->where('unity_id', backpack_user()->unity->id);

        // } else {
        //     abort(403);
        // }

        if ($search_term) {
            $results = $options->where('transit_number', 'LIKE', '%'.$search_term.'%')->paginate(10);
        } else {
            $results = $options->paginate(10);
        }

        return $results;
    }

    public function show($id)
    {
        return Truck::find($id);
    }
}

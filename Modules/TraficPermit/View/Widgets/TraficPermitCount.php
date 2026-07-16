<?php

namespace Modules\TraficPermit\View\Widgets;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;
use Modules\TraficPermit\Enums\TransactionType;
use Modules\TraficPermit\Models\Repository;
use Modules\TraficPermit\Models\TraficPermitExport;
use Modules\TraficPermit\Models\Transaction;

class TraficPermitCount extends Component
{
    public $traficpermits;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $exports = TraficPermitExport::whereExists(function ($query) {
            $query
            ->select(DB::raw('*'))
            ->from('permit_orders')
            ->whereColumn('permit_orders.id', 'permit_order_id')
            ->where('permit_order_trafic_permit.status', 1)
            ->join('unities', 'unities.id', '=', 'permit_orders.unity_id')
            ->where('unities.id', backpack_user()->unity->id);
        })->count();

        $this->traficpermits = $exports;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('traficpermit::widgets.traficpermit-count');
    }
}

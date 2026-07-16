<?php

namespace Modules\TraficPermit\View\Widgets;

use Carbon\Carbon;
use Illuminate\View\Component;
use Modules\TraficPermit\Enums\TransactionType;
use Modules\TraficPermit\Models\Repository;
use Modules\TraficPermit\Models\Transaction;

class Wallet extends Component
{
    public $wallet;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $wallet = backpack_user()->unity->cashed_balance;
        $this->wallet = number_format($wallet);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('traficpermit::widgets.wallet');
    }
}

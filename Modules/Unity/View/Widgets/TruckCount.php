<?php

namespace Modules\Unity\View\Widgets;

use Illuminate\View\Component;

class TruckCount extends Component
{
    public $trucks;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->trucks = backpack_user()->unity->trucks()->count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('unity::admin.widgets.truck-count');
    }
}

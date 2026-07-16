<?php

namespace Modules\Unity\View\Widgets;

use Illuminate\View\Component;

class DriverCount extends Component
{
    public $drivers;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->drivers = backpack_user()->unity->drivers()->count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('unity::admin.widgets.driver-count');
    }
}

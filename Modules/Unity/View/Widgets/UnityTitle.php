<?php

namespace Modules\Unity\View\Widgets;

use Illuminate\View\Component;

class UnityTitle extends Component
{
    public $unity;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->unity = backpack_user()->unity;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('unity::admin.widgets.unity-title');
    }
}

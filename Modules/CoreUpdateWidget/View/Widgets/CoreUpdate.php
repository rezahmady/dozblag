<?php

namespace Modules\CoreUpdateWidget\View\Widgets;

use App\Models\User;
use Illuminate\View\Component;
use Modules\Chat\Models\Room;

class CoreUpdate extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('coreupdatewidget::admin.widgets.core-update');
    }
}

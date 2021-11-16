<?php

namespace Modules\User\View\Widgets;

use App\Models\User;
use Illuminate\View\Component;
use Modules\Chat\Models\Room;

class CustomersNumber extends Component
{
    public $customers;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->customers = User::where('template', 'customer')->count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('user::admin.widgets.customers-number');
    }
}

<?php

namespace Modules\User\View\Widgets;

use App\Models\User;
use Illuminate\View\Component;
use Modules\Chat\Models\Room;

class DoctorsNumber extends Component
{
    public $doctors;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->doctors = User::where('template', 'doctor')->count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('user::admin.widgets.doctors-number');
    }
}

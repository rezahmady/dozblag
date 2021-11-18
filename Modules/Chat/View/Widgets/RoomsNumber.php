<?php

namespace Modules\Chat\View\Widgets;

use App\Models\User;
use Illuminate\View\Component;
use Modules\Chat\Models\Room;

class RoomsNumber extends Component
{
    public $rooms;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->rooms = Room::count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('chat::admin.widgets.rooms-number');
    }
}

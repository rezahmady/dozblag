<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Room;

class Rooms extends Component
{

    public $rooms;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $id = auth()->id();
        $this->rooms = Room::where('user_id',$id)
        ->with('latestMessage')
        ->orWhere('doctor_id', $id)
        ->orWhere('operator_id', $id)
        ->get()->sortByDesc('latestMessage.created_at');
    }
    
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('livewire.chat.rooms');
    }
}

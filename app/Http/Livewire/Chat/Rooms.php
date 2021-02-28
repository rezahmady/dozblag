<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\Room;

class Rooms extends Component
{
    public $rooms;

    public function getListeners() {
        return [
            "echo-private:chat.1,Chat\\MessageAdded" => '$refresh',
        ];
    }

    public function mount()
    {
        $id = auth()->id();
        $this->rooms = Room::where('user_id',$id)->orWhere('doctor_id', $id)->orWhere('operator_id', $id)->get(); //auth()->user()->rooms;
    }
    
    public function render()
    {
        return view('livewire.chat.rooms');
    }
}

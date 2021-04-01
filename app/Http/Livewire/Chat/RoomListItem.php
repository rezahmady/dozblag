<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\Room;
use App\Http\Livewire\Traits\WithAudience;

class RoomListItem extends Component
{
    use WithAudience;
    
    public $room;

    public $unread = 0;

    public $currentRoom;

    public $status;

    public function setStatusOnline()
    {
        return $this->status = 1;
    }

    // public function getListeners() {
    //     return [
    //         "echo-private:chat.{$this->room->id},Chat\\MessageAdded" => "incrementUnread",
    //     ];
    // }

    public function incrementUnread()
    {
        $this->unread++;
    }

    public function mount(Room $room)
    {
        $this->room = $room;

        $this->getAudience($room);

        $this->unread = $room->messages()->where('user_id', '!=', auth()->id())->whereNull('seen')->count();
        
    }

    public function render()
    {
        return view('livewire.chat.room-list-item');
    }
}

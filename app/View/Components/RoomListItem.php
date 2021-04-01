<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Room;
use App\Http\Livewire\Traits\WithAudience;

class RoomListItem extends Component
{

    use WithAudience;
    
    public $room;

    public $unread = 0;

    public $currentRoom;

    public $message;

    public $status;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Room $room)
    {
        $this->room = $room;

        $this->getAudience($room);

        $this->unread = $room->messages()->where('user_id', '!=', auth()->id())->whereNull('seen')->count();

        $this->message = $room->messages()->latest()->first();

        if($room->user->id === auth()->id() and auth()->user()->template == 'customer') {
            $this->status = 'chat';
        } elseif($room->operator === null and $room->user->template === 'customer'){
            $this->status = 'suggest';
        } elseif($room->status === 'archive') {
            $this->status = 'archive';
        } else {
            $this->status = 'chat';
        }
        
    }

    

    public function incrementUnread()
    {
        $this->unread++;
    }

    public function selectRoom()
    {
        // $this->emit('setRoom', $this->room->id);
        $this->unread = 0;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('livewire.chat.room-list-item');
    }

}

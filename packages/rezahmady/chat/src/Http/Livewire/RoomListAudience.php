<?php

namespace Rezahmady\Chat\Http\Livewire;

use Livewire\Component;

class RoomListAudience extends Component
{
    public $audience;

    public $room;

    public $status;

    public $users;

    protected $listeners = [
        'echo-presence:chat,here'                           => 'setUsersHere',
        'echo-presence:chat,joining'                        => 'setUserJoining',
        'echo-presence:chat,leaving'                        => 'setUserLeaving',
    ];

    public function mount($audience, $room)
    {
        $this->audience = $audience;
        $this->room = $room;
        $users = [];
        if(auth()->id() === $room->user->id) {
            if($room->doctor) $users[] = $room->doctor->id;
            if($room->operator) $users[] = $room->operator->id;
            $this->users = $users;
        }
        $this->status = 0;
    }

    public function setUsersHere($users) 
    {
        
        if($this->users) {
            foreach ($this->users as $value) {
                $found_key = array_search($value, array_column($users, 'id'));
                if($found_key !== false) {
                    $this->status = 1;
                    break;
                }
            }
        } else {
            $found_key = array_search($this->audience->id, array_column($users, 'id'));
            if($found_key !== false) {
                $this->status = 1;
            }
        }
    }

    public function setUserJoining($user) 
    {
        if($this->audience->id === $user['id']) $this->status = 1;
    }

    public function setUserLeaving($user) 
    {
        if($this->audience->id === $user['id']) $this->status = 0;
    }

    public function render()
    {
        return view('rezahmady.chat::skin.room-list-audience');
    }
}

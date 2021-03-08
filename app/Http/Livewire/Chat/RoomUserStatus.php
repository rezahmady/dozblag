<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;

class RoomUserStatus extends Component
{
    public $audience;

    public $status;

    public $room;

    public $onlineUsers;

    public $users;

    protected $listeners = [
        'echo-presence:chat,here'     => 'setUsersHere',
        'echo-presence:chat,joining'  => 'setUserJoining',
        'echo-presence:chat,leaving'  => 'setUserLeaving',
        'refreshUserStatus',
    ];

    public function refreshUserStatus($onlineUsers)
    {
        $this->onlineUsers = $onlineUsers;
        $users = [];
        if(auth()->id() === $this->room->user->id) {
            if($this->room->doctor) $users[] = $this->room->doctor->id;
            if($this->room->operator) $users[] = $this->room->operator->id;
        }
        if($onlineUsers) {
            if($users) {
                foreach ($this->users as $value) {
                    $found_key = array_search($value, array_column($onlineUsers, 'id'));
                    if($found_key !== false) {
                        $this->status = 1;
                        break;
                    }
                }
            } else {
                $found_key = array_search($this->audience->id, array_column($onlineUsers, 'id'));
                if($found_key !== false) {
                    $this->status = 1;
                }
            }
        }
    }

    public function mount($room, $audience, $onlineUsers)
    {
        $this->room = $room;
        $this->audience = $audience;
        if(auth()->id() === $room->user->id) {
            if($room->doctor) $users[] = $room->doctor->id;
            if($room->operator) $users[] = $room->operator->id;
            $this->users = $users;
        }
        if($onlineUsers) {
            if($this->users) {
                foreach ($this->users as $value) {
                    $found_key = array_search($value, array_column($onlineUsers, 'id'));
                    if($found_key !== false) {
                        $this->status = 1;
                        break;
                    }
                }
            } else {
                $found_key = array_search($this->audience->id, array_column($onlineUsers, 'id'));
                if($found_key !== false) {
                    $this->status = 1;
                }
            }
        }
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
        $this->status = 1;
    }

    public function setUserLeaving($user) 
    {
        $this->status = 0;
    }

    public function render()
    {
        return view('livewire.chat.room-user-status');
    }
}

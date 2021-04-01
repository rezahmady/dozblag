<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Room;

class Archives extends Component
{
    public $rooms;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->rooms = Room::where('extras->status', 'archive')->get();
    }

    

    public function incrementUnread()
    {
        $this->unread++;
    }

    public function selectRoom()
    {
        $this->unread = 0;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('livewire.chat.archives');
    }
}

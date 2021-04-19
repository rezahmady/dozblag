<?php

namespace Rezahmady\Chat\View\Components;

use Illuminate\View\Component;

class RoomSidebar extends Component
{
    public $room;

    public $photos;

    public $audience;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($room, $audience)
    {
        $this->room = $room;
        $this->audience = $audience;
        $files = [];
        if($room) {
            $messages = $room->messages()->where('type','photos')->get();
            foreach ($messages as  $message) {
                $files = array_merge($files, json_decode($message->body));
            }
            $this->photos = $files;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('rezahmady.chat::skin.room-sidebar');
    }
}

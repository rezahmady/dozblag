<?php

namespace Rezahmady\Chat\View\Components;

use App\Models\User;
use Illuminate\View\Component;

class RoomSidebar extends Component
{
    public $room;

    public $photos;

    public $medical_folder = [];

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
            $this->getMedicalFolder();
        }
    }

    public function getMedicalFolder() {
        if(backpack_user()->template != 'customer') {
            $this->medical_folder = json_decode(User::find($this->room->user_id)->extras->medical_folder, true);
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

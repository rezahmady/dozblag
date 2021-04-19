<?php

namespace Rezahmady\Chat\View\Components;

use Illuminate\View\Component;

class Room extends Component
{

    public $room;

    public $audience;

    public $onlineUsers;

    public $status;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($room, $audience, $onlineUsers)
    {
        $this->room = $room;
        $this->audience = $audience;
        $this->onlineUsers = $onlineUsers;
        if($room) {
            if($room->operator === null and $room->user->template === 'customer'){
                $this->status = 'suggest';
            } elseif($room->status === 'archive') {
                $this->status = 'archive';
            } else {
                $this->status = 'chat';
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        if($this->room) {
            
            return view('rezahmady.chat::skin.room');
        } 
        else {
            return <<<'blade'
                <div style="width:100%;position:relative">
                    <div class="container p-3 empty-chat-holder" >
                        <img  class="empty-chat-img" src="{{url('/packages/chatino/media/img/consultation-empty.svg')}}" >
                        <p class="empty-chat-text">برای ادامه یکی از گفتگو ها را انتخاب کنید</p>
                    </div>
                </div>
            blade;
        }

    }
}

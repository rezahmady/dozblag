<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\Room as RoomModel;
use App\Http\Livewire\Traits\WithAudience;
use App\Events\Chat\MessageSeen;

class Room extends Component
{
    use WithAudience;

    public $room;
    
    protected $listeners = ['setRoom'];

    public function setRoom($id)
    {
        $this->room = RoomModel::findOrFail($id);
        $this->getAudience($this->room);
        $this->emit('rerenderMessages', $id);
        

        $last = $this->room->messages()->latest('id')->first();
        if($last) {
            $this->seenMessages($last->id);
        }
    }

    public function seenMessages($messageId)
    {
        $messages = $this->room->messages()
        ->where('id', '<=', $messageId)
        ->where('user_id', '!=', auth()->id())
        ->update([
            'seen' => 1
        ]);

        broadcast(new MessageSeen($this->room->id))->toOthers();

    }

    public function render()
    {
        if($this->room) {
            return view('livewire.chat.room');
        } else {
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
        
        
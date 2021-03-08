<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\Chat;
use App\Models\Room;
use App\Events\Chat\MessageAdded;
use Livewire\WithFileUploads;

class CreateMessage extends Component
{

    use WithFileUploads;

    public $body;

    public $parent;

    public $reply;

    public $file;

    public $room;

    protected $listeners = [
        'rerenderCreateMessage',
    ];

    public function mount(Room $room)
    {
        $this->room = $room;
    }

    public function rerenderCreateMessage(Room $room)
    {
        $this->room = $room;
    }

    protected $rules = [
        'body' => 'required',
    ];

    public function submit()
    {
        $this->validate();
        $message = auth()->user()->messages()->create([
            'body'       => $this->body,
            'room_id'    => $this->room->id,
            'parent_id'  => $this->parent
        ]);
            
        $this->emit('message-added', $message->id);

        $sender = auth()->id();
        
        broadcast(new MessageAdded($this->room->id, $message->id, $sender))->toOthers();

        $this->body = $this->parent_id = $this->score = $this->reply = null;
        

    }

    public function setBody($body) {
        $this->body = $body;
    }


    public function render()
    {
        return view('livewire.chat.create-message');
    }
}

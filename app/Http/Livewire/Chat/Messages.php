<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Events\Chat\MessageSeen;
use App\Events\Chat\MessageSeenResponse;
use App\Models\Chat;
use App\Models\Room as RoomModel;

class Messages extends Component
{
    public $room;

    public $messages;

    public $rerender;

    public function getListeners()
    {
        $sender = auth()->id();
        return [
            'message-added' => 'prependMessage',
            'rerenderMessages',
            "echo-private:chat.{$this->room->id},Chat\\MessageAdded" => "prependMessageFromBroadcasting",
            "echo-private:chat.{$this->room->id},Chat\\MessageSeen" => '$refresh',
            "echo-private:chat.{$this->room->id}.user.{$sender},Chat\\MessageSeenResponse" => '$refresh',
        ];
    }

    public function rerenderMessages($id) {
        $this->room = RoomModel::findOrFail($id);
        $this->messages = $this->room->messages()->orderBy('created_at', 'desc')->get();
        $this->emitUp('ShowRoom');
    }

    public function prependMessageFromBroadcasting($payload)
    {
        $this->prependMessage($payload['messageId']);
        $this->seenFromBroadcasting($payload);
        // broadcast(new MessageSeen($this->room->id, $payload['messageId'], $payload['sender']))->toOthers();
    }

    public function prependMessage($id)
    {
        $this->messages = $this->room->messages->reverse();
        $this->dispatchBrowserEvent('scrollTo', ['hash' => "message-{$id}"]);
    }

    public function seenFromBroadcasting($payload)
    {
        $messages = $this->room->messages()
        ->where('id', '<=', $payload['messageId'])
        ->where('user_id', $payload['sender'])
        ->update([
            'seen' => 1
        ]);

        broadcast(new MessageSeenResponse($this->room->id, $payload['messageId'], $payload['sender']))->toOthers();

    }

    public function mount()
    {
        $this->messages = $this->room->messages()->orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.chat.messages');
    }
}

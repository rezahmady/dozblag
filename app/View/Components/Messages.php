<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Http\Livewire\Traits\WithAudience;

class Messages extends Component
{

    use WithAudience;

    public $room;
    
    public $audience;

    public $messages;

    public $rerender;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($room, $audience)
    {
        $this->room = $room;
        $this->audience = $audience;
        $this->messages = $this->room->messages()->orderBy('created_at', 'desc')->get();
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

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('livewire.chat.messages');
    }
}

<?php

namespace Modules\Chat\View\Components;

use Illuminate\View\Component;
use Modules\Chat\Http\Livewire\Traits\WithAudience;
use Modules\Chat\Events\Chat\MessageSeenResponse;
use Modules\Chat\Models\Room;

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

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('chat::skin.messages');
    }
}

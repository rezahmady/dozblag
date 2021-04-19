<?php

namespace Rezahmady\Chat\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSeenResponse implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sender;

    public $roomId;

    public $messageId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($roomId, $messageId, $sender)
    {
        $this->roomId = $roomId;
        $this->messageId = $messageId;
        $this->sender = $sender;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("chat.{$this->roomId}.user.{$this->sender}");
    }
}

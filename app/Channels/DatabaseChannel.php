<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use App\Models\Message;

class DatabaseChannel
{
    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        # get data from notification class
        $info = $notification->toDb($notifiable);
        $user_id = $notifiable->id;
        
 
        $newMessage = new Message();
        
        $newMessage->subject = $info['subject'];
        $newMessage->type = 'system';
        $newMessage->content = $info['message'];
        $newMessage->to = $user_id;
        $newMessage->status = 0;

        $newMessage->save();

    }
}
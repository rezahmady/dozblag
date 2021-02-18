<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

class SmsChannel
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
        $message = $notification->toSms($notifiable);
        $mobile = $notifiable->mobile;
        
        // send sms here ...

    }
}
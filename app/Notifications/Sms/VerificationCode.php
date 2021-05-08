<?php

namespace App\Notifications\Sms;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Rezahmady\Smsir\SmsirChannel;
use Rezahmady\Smsir\SmsirMessage;

class VerificationCode extends Notification
{
    use Queueable;

    public $parameter;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($parameter)
    {
        //
        $this->parameter = $parameter;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SmsirChannel::class];
    }

    public function toSmsir($notifiable)
    {
        return (new SmsirMessage())
                ->setMethod('ultraFastSend')
                ->setTemplateId('47119')
                ->setParameters([
                    'VerificationCode' => $this->parameter
                ]);
        
    }

}

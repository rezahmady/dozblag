<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Registered;

class AssignUserRole
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        User::find($event->user->id)->assignRole('کاربر');
    }
}

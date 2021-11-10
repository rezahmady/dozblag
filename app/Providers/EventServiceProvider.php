<?php

namespace App\Providers;

use App\Events\ConsultationAdded;
use App\Notifications\Doctor\NewRoom as DoctorNewRoom;
use App\Notifications\Operator\NewRoom;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Registered::class => [
        //     SendEmailVerificationNotification::class,
        // ],

        // DisplayAdminMenu::class => [
        //     ModuleMenuListener::class
        // ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        // Event::listen('revisionable.*', function($model, $revisions) {
        //     // Do something with the revisions or the changed model.
        //     dd($model, $revisions);
        // });
    }
}

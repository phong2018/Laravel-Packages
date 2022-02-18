<?php

namespace  Phonglg\LaravelEventsListeners\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Phonglg\LaravelEventsListeners\Events\WelcomeUser; 
use Phonglg\LaravelEventsListeners\Listeners\SendEmailWelcome;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        WelcomeUser::class => [
            SendEmailWelcome::class,
        ]
    ];
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
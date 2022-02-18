<?php

namespace Phonglg\LaravelEventsListeners\Listeners;

use Illuminate\Support\Facades\Mail;
use Phonglg\LaravelEventsListeners\Events\WelcomeUser;
use Phonglg\LaravelEventsListeners\Mail\WelcomeMail;

class SendEmailWelcome
{
    public function handle(WelcomeUser $event)
    {
        Mail::to('hoccode.net@gmail.com')->send(new WelcomeMail($event->welcomeMessage));
    }
}
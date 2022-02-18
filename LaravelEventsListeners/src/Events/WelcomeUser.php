<?php

namespace Phonglg\LaravelEventsListeners\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable; 

class WelcomeUser
{
    use Dispatchable, SerializesModels;

    public $welcomeMessage;

    public function __construct($welcomeMessage)
    {
        $this->welcomeMessage = $welcomeMessage;
    }
}
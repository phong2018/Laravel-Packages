<?php

namespace Phonglg\LaravelHtmlDomParser\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable; 

class DrawXoSoMax3DEvent
{
    use Dispatchable, SerializesModels;

    public function __construct()
    {
    }
}
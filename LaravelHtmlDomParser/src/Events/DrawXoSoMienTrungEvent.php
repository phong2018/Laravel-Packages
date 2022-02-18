<?php

namespace Phonglg\LaravelHtmlDomParser\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable; 

class DrawXoSoMienTrungEvent
{
    use Dispatchable, SerializesModels;

    public function __construct()
    {
    }
}
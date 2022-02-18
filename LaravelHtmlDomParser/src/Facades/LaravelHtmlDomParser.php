<?php

namespace Phonglg\LaravelHtmlDomParser\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelHtmlDomParser extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravelhtmldomparser';
    }
}

<?php

namespace Phonglg\LaravelVeso\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelVeso extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravelveso';
    }
}

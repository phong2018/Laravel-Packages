<?php

namespace Phonglg\LaravelZaloPay\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelZaloPay extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravelzalopay';
    }
}

<?php

namespace Phonglg\LaravelVnPay\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelVnPay extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravelvnpay';
    }
}

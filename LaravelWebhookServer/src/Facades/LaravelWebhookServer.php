<?php

namespace Phonglg\LaravelWebhookServer\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelWebhookServer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravelwebhookserver';
    }
}

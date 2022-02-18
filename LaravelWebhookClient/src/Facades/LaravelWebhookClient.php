<?php

namespace Phonglg\LaravelWebhookClient\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelWebhookClient extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravelwebhookclient';
    }
}

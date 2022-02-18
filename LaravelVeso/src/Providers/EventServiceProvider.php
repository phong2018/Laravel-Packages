<?php

namespace  Phonglg\LaravelVeso\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Phonglg\LaravelVeso\Events\PaidOrderSuccess;
use Phonglg\LaravelVeso\Events\PrintTicketSuccess;
use Phonglg\LaravelVeso\Listeners\PrintTicket;
use Phonglg\LaravelVeso\Listeners\UpdateOrderDetailStatus;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PaidOrderSuccess::class => [
            PrintTicket::class,
        ],
        PrintTicketSuccess::class => [
            UpdateOrderDetailStatus::class,
        ]
    ];
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
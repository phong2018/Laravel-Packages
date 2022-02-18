<?php

namespace  Phonglg\LaravelHtmlDomParser\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoKenoEvent;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMienNamEvent;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMienTrungEvent;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMienBacEvent;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMega645Event;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoPower655Event;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMax3DEvent;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMax3DProEvent;
use Phonglg\LaravelHtmlDomParser\Events\MonitorOrderDetailWatingEvent;
use Phonglg\LaravelHtmlDomParser\Events\MonitorPrintTicketEvent;
use Phonglg\LaravelHtmlDomParser\Listeners\DrawXoSoKenoListener;
use Phonglg\LaravelHtmlDomParser\Listeners\DrawXoSoMienNamListener;
use Phonglg\LaravelHtmlDomParser\Listeners\DrawXoSoMienTrungListener;
use Phonglg\LaravelHtmlDomParser\Listeners\DrawXoSoMienBacListener;
use Phonglg\LaravelHtmlDomParser\Listeners\DrawXoSoMega645Listener;
use Phonglg\LaravelHtmlDomParser\Listeners\DrawXoSoPower655Listener;
use Phonglg\LaravelHtmlDomParser\Listeners\DrawXoSoMax3DListener;
use Phonglg\LaravelHtmlDomParser\Listeners\DrawXoSoMax3DProListener;
use Phonglg\LaravelHtmlDomParser\Listeners\MonitorOrderDetailWatingListener;
use Phonglg\LaravelHtmlDomParser\Listeners\MonitorPrintTicketListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        DrawXoSoMienNamEvent ::class => [
            DrawXoSoMienNamListener::class,
        ],
        DrawXoSoMienTrungEvent::class => [
            DrawXoSoMienTrungListener::class,
        ],
        DrawXoSoMienBacEvent::class => [
            DrawXoSoMienBacListener::class,
        ],
        DrawXoSoMega645Event::class => [
            DrawXoSoMega645Listener::class,
        ],
        DrawXoSoPower655Event::class => [
            DrawXoSoPower655Listener::class,
        ],
        DrawXoSoMax3DEvent::class => [
            DrawXoSoMax3DListener::class,
        ],
        DrawXoSoMax3DProEvent::class => [
            DrawXoSoMax3DProListener::class,
        ],
        DrawXoSoKenoEvent::class => [
            DrawXoSoKenoListener::class,
        ],
        MonitorPrintTicketEvent::class=>[
            MonitorPrintTicketListener::class
        ],
        MonitorOrderDetailWatingEvent::class=>[
            MonitorOrderDetailWatingListener::class
        ],

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

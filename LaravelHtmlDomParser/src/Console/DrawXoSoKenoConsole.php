<?php

namespace Phonglg\LaravelHtmlDomParser\Console;
 
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoKenoEvent;
use Phonglg\LaravelHtmlDomParser\Events\MonitorOrderDetailWatingEvent;
use Phonglg\LaravelHtmlDomParser\Events\MonitorPrintTicketEvent;

class DrawXoSoKenoConsole extends Command
{
    protected $signature = 'xoso:drawXoSoKeno';

    protected $description = 'Draw Data From Website';
    
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Run DrawDataFromWebsite xoso:drawXoSoKeno...');

        Log::debug('xoso:drawXoSoKeno MonitorOrderDetailWatingEvent');
        event(new  MonitorOrderDetailWatingEvent()); //for call api print for order detail waiting, because prevent print
        
        Log::debug('xoso:drawXoSoKeno call event MonitorPrintTicketEvent');
        event(new MonitorPrintTicketEvent());

        Log::debug('xoso:drawXoSoKeno Command into laravel.log');
        event(new DrawXoSoKenoEvent()); 

        $this->info('Finished DrawDataFromWebsite xoso:drawXoSoKeno...'); 
    }
  
}
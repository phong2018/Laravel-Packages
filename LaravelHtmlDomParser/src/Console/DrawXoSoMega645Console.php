<?php

namespace Phonglg\LaravelHtmlDomParser\Console;
 
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMega645Event;

class DrawXoSoMega645Console extends Command
{
    protected $signature = 'xoso:drawXoSoMega645';

    protected $description = 'Draw Data From Website';
    
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Run DrawDataFromWebsite xoso:drawXoSoMega645...');

        Log::debug('xoso:drawXoSoMega645 Command into laravel.log');
 
        event(new DrawXoSoMega645Event());

        $this->info('Finished DrawDataFromWebsite xoso:drawXoSoMega645...'); 
    }
  
}
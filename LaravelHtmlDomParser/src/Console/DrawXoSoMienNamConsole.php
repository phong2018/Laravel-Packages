<?php

namespace Phonglg\LaravelHtmlDomParser\Console;
 
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMienNamEvent;

class DrawXoSoMienNamConsole extends Command
{
    protected $signature = 'xoso:drawXoSoMienNam';

    protected $description = 'Draw Data From Website';
    
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Run DrawDataFromWebsite xoso:drawXoSoMienNam...');

        Log::debug('DrawDataFromWebsiteConsole Command into laravel.log');
 
        event(new DrawXoSoMienNamEvent());

        $this->info('Finished DrawDataFromWebsite xoso:drawXoSoMienNam...'); 
    }
  
}
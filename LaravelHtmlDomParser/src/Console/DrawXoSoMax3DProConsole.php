<?php

namespace Phonglg\LaravelHtmlDomParser\Console;
 
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMax3DProEvent;

class DrawXoSoMax3DProConsole extends Command
{
    protected $signature = 'xoso:drawXoSoMax3DPro';

    protected $description = 'Draw Data From Website';
    
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Run DrawDataFromWebsite xoso:drawXoSoMax3DPro...');

        Log::debug('xoso:drawXoSoMax3DPro Command into laravel.log');
 
        event(new DrawXoSoMax3DProEvent());

        $this->info('Finished DrawDataFromWebsite xoso:drawXoSoMax3DPro...'); 
    }
  
}
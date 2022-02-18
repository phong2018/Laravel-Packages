<?php

namespace Phonglg\LaravelHtmlDomParser\Console;
 
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMienBacEvent;

class DrawXoSoMienBacConsole extends Command
{
    protected $signature = 'xoso:drawXoSoMienBac';

    protected $description = 'Draw Data From Website';
    
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Run DrawDataFromWebsite xoso:drawXoSoMienBac...');

        Log::debug('xoso:drawXoSoMienBac Command into laravel.log');
 
        event(new DrawXoSoMienBacEvent());

        $this->info('Finished DrawDataFromWebsite xoso:drawXoSoMienBac...'); 
    }
  
}
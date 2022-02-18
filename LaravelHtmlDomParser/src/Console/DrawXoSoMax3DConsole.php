<?php

namespace Phonglg\LaravelHtmlDomParser\Console;
 
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMax3DEvent;

class DrawXoSoMax3DConsole extends Command
{
    protected $signature = 'xoso:drawXoSoMax3D';

    protected $description = 'Draw Data From Website';
    
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Run DrawDataFromWebsite xoso:drawXoSoMax3D...');

        Log::debug('xoso:drawXoSoMax3D Command into laravel.log');
 
        event(new DrawXoSoMax3DEvent());

        $this->info('Finished DrawDataFromWebsite xoso:drawXoSoMax3D...'); 
    }
  
}
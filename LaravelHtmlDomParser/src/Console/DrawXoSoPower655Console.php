<?php

namespace Phonglg\LaravelHtmlDomParser\Console;
 
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoPower655Event;

class DrawXoSoPower655Console extends Command
{
    protected $signature = 'xoso:drawXoSoPower655';

    protected $description = 'Draw Data From Website';
    
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Run DrawDataFromWebsite xoso:drawXoSoPower655...');

        Log::debug('xoso:drawXoSoPower655 Command into laravel.log');
 
        event(new DrawXoSoPower655Event());

        $this->info('Finished DrawDataFromWebsite xoso:drawXoSoPower655...'); 
    }
  
}
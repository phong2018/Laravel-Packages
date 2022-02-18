<?php

namespace Phonglg\LaravelHtmlDomParser\Console;
 
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMienTrungEvent;

class DrawXoSoMienTrungConsole extends Command
{
    protected $signature = 'xoso:drawXoSoMienTrung';

    protected $description = 'Draw Data From Website';
    
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Run DrawDataFromWebsite xoso:drawXoSoMienTrung...');

        Log::debug('xoso:drawXoSoMienTrung Command into laravel.log');
 
        event(new DrawXoSoMienTrungEvent());

        $this->info('Finished DrawDataFromWebsite xoso:drawXoSoMienTrung...'); 
    }
  
}
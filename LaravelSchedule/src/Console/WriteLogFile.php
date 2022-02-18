<?php

namespace Phonglg\LaravelSchedule\Console;
 
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelEventsListeners\Events\WelcomeUser;

class WriteLogFile extends Command
{
    protected $signature = 'logfile:write';

    protected $description = 'Write into LogFile';
    
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Run logfile:write...');

        Log::debug('WriteLogFile Command into laravel.log');

        //test call event sendemail welcome from package LaravelEventsListerners
        event(new WelcomeUser('Welcome you come to Website using Command Artisan'));

        $this->info('Finished logfile:write');
    }
  
}
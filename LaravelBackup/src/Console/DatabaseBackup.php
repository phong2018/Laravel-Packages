<?php
namespace Phonglg\LaravelBackup\Console;
  
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; 
use Phonglg\LaravelBackup\Helpers\BackupHelper;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';
  
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
  
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
  
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Storage::put('Laravel/DB.sql', 'HLEO WORKLD');	
        Log::debug('call database:backup');
        BackupHelper::createBackup();
    }
}
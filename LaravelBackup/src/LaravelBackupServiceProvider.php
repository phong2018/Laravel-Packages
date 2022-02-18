<?php

namespace Phonglg\LaravelBackup;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Phonglg\LaravelBackup\Console\DatabaseBackup;
use Phonglg\LaravelBackup\Policies\BackupPolicy;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Log;

class LaravelBackupServiceProvider extends ServiceProvider
{ 

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */

    public function registerGate(){
        Gate::define('backupDB', [BackupPolicy::class, 'backup']);
    } 

    public function boot(): void
    { 
        // register Gate
        $this->registerGate();
 

        // config disk for filesystems
        config(['filesystems.disks.'.config('laravelbackup.name') =>config('laravelbackup.disk')]);  

        // load view
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravelbackup'); 
        
        // load route
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'phonglg');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'phonglg');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();

            // Schedule the command draw
            $this->app->booted(function () {
                $schedule = $this->app->make(Schedule::class); 

                // getDataTraditionalLottery
                $schedule->command('database:backup')
                ->dailyAt('1:00');
                //->twiceDaily(1, 13);
                //->everyTwoMinutes();

            });

        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravelbackup.php', 'laravelbackup');

        // Register the service the package provides.
        $this->app->singleton('laravelbackup', function ($app) {
            return new LaravelBackup;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelbackup'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/laravelbackup.php' => config_path('laravelbackup.php'),
        ], 'laravelbackup.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/phonglg'),
        ], 'laravelbackup.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/phonglg'),
        ], 'laravelbackup.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/phonglg'),
        ], 'laravelbackup.views');*/

        // Registering package commands.
        // $this->commands([]);

        $this->commands([
            DatabaseBackup::class,
        ]); 

        
    }
}

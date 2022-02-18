<?php

namespace Phonglg\LaravelHtmlDomParser;

use Illuminate\Support\ServiceProvider;
use Phonglg\LaravelHtmlDomParser\Console\DrawXoSoKenoConsole;
use Phonglg\LaravelHtmlDomParser\Console\DrawXoSoMax3DConsole;
use Phonglg\LaravelHtmlDomParser\Console\DrawXoSoMax3DProConsole;
use Phonglg\LaravelHtmlDomParser\Console\DrawXoSoMega645Console;
use Phonglg\LaravelHtmlDomParser\Console\DrawXoSoMienBacConsole;
use Phonglg\LaravelHtmlDomParser\Console\DrawXoSoMienNamConsole;
use Phonglg\LaravelHtmlDomParser\Console\DrawXoSoMienTrungConsole;
use Phonglg\LaravelHtmlDomParser\Console\DrawXoSoPower655Console;
use Phonglg\LaravelHtmlDomParser\Providers\EventServiceProvider; 
use Illuminate\Console\Scheduling\Schedule;

class LaravelHtmlDomParserServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations'); 
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravelhtmldomparser');

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
                $schedule->command('xoso:drawXoSoMienNam')
                ->everyMinute()
                ->between('16:00', '17:15');
                $schedule->command('xoso:drawXoSoMienTrung')
                ->everyMinute()
                ->between('17:00', '18:15');//17
                $schedule->command('xoso:drawXoSoMienBac')
                ->everyMinute()
                ->between('18:00', '19:15');//18

                // getVietlott
                $schedule->command('xoso:drawXoSoMega645')
                ->everyThreeMinutes()
                ->between('16:00', '19:30');//18
                $schedule->command('xoso:drawXoSoPower655')
                ->everyThreeMinutes()
                ->between('16:00', '19:30');
                $schedule->command('xoso:drawXoSoMax3D')
                ->everyThreeMinutes()
                ->between('16:00', '19:30');
                $schedule->command('xoso:drawXoSoMax3DPro')
                ->everyThreeMinutes()
                ->between('16:00', '19:30');
                
                $schedule->command('xoso:drawXoSoKeno')
                ->everyTwoMinutes()
                ->between('06:00', '22:10');
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

        // plg register event & listener
        $this->app->register(EventServiceProvider::class);

        $this->mergeConfigFrom(__DIR__.'/../config/laravelhtmldomparser.php', 'laravelhtmldomparser');

        // Register the service the package provides.
        $this->app->singleton('laravelhtmldomparser', function ($app) {
            return new LaravelHtmlDomParser;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelhtmldomparser'];
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
            __DIR__.'/../config/laravelhtmldomparser.php' => config_path('laravelhtmldomparser.php'),
        ], 'laravelhtmldomparser.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/phonglg'),
        ], 'laravelhtmldomparser.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/phonglg'),
        ], 'laravelhtmldomparser.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/phonglg'),
        ], 'laravelhtmldomparser.views');*/

        // Registering package commands. 
        $this->commands([
            DrawXoSoMienNamConsole::class,
            DrawXoSoMienTrungConsole::class,
            DrawXoSoMienTrungConsole::class,
            DrawXoSoMienBacConsole::class,
            DrawXoSoMega645Console::class,
            DrawXoSoPower655Console::class,
            DrawXoSoMax3DConsole::class,
            DrawXoSoMax3DProConsole::class,
            DrawXoSoKenoConsole::class,
        ]); 
    }
}


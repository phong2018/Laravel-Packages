<?php

namespace Phonglg\LaravelVue;

use Illuminate\Support\ServiceProvider;

class LaravelVueServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravelvue'); 
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'phonglg');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'phonglg');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravelvue.php', 'laravelvue');

        // Register the service the package provides.
        $this->app->singleton('laravelvue', function ($app) {
            return new LaravelVue;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelvue'];
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
            __DIR__.'/../config/laravelvue.php' => config_path('laravelvue.php'),
        ], 'laravelvue.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/phonglg'),
        ], 'laravelvue.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/phonglg'),
        ], 'laravelvue.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/phonglg'),
        ], 'laravelvue.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}

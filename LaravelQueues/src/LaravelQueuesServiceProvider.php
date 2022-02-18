<?php

namespace Phonglg\LaravelQueues;

use Illuminate\Support\ServiceProvider;

class LaravelQueuesServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravelqueues');
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
        $this->mergeConfigFrom(__DIR__.'/../config/laravelqueues.php', 'laravelqueues');

        // Register the service the package provides.
        $this->app->singleton('laravelqueues', function ($app) {
            return new LaravelQueues;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelqueues'];
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
            __DIR__.'/../config/laravelqueues.php' => config_path('laravelqueues.php'),
        ], 'laravelqueues.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/phonglg'),
        ], 'laravelqueues.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/phonglg'),
        ], 'laravelqueues.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/phonglg'),
        ], 'laravelqueues.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}

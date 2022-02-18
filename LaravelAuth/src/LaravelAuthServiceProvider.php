<?php

namespace Phonglg\LaravelAuth;

use Illuminate\Support\ServiceProvider;
use Phonglg\LaravelAuth\Policies\AccountPolicy;
use Illuminate\Support\Facades\Gate;

class LaravelAuthServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {      
        Gate::define('Account:update', [AccountPolicy::class, 'update']);

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravelauth');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');  
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

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
        $this->mergeConfigFrom(__DIR__.'/../config/laravelauth.php', 'laravelauth');

        // Register the service the package provides.
        $this->app->singleton('laravelauth', function ($app) {
            return new LaravelAuth;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelauth'];
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
            __DIR__.'/../config/laravelauth.php' => config_path('laravelauth.php'),
        ], 'laravelauth.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/phonglg'),
        ], 'laravelauth.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/phonglg'),
        ], 'laravelauth.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/phonglg'),
        ], 'laravelauth.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}

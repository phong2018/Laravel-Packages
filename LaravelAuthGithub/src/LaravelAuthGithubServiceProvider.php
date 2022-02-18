<?php

namespace Phonglg\LaravelAuthGithub;

use Illuminate\Support\ServiceProvider;

class LaravelAuthGithubServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {  
 

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        //because: \laravelpackages\vendor\laravel\socialite\src\SocialiteManager.php
        config(['services.github' =>  config('laravelauthgithub.github')]);

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
        $this->mergeConfigFrom(__DIR__.'/../config/laravelauthgithub.php', 'laravelauthgithub');

        // Register the service the package provides.
        $this->app->singleton('laravelauthgithub', function ($app) {
            return new LaravelAuthGithub;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelauthgithub'];
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
            __DIR__.'/../config/laravelauthgithub.php' => config_path('laravelauthgithub.php'),
        ], 'laravelauthgithub.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/phonglg'),
        ], 'laravelauthgithub.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/phonglg'),
        ], 'laravelauthgithub.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/phonglg'),
        ], 'laravelauthgithub.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}

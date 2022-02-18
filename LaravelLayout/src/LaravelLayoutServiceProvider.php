<?php

namespace Phonglg\LaravelLayout;

use Illuminate\Support\ServiceProvider;
use Phonglg\LaravelLayout\Components;

class LaravelLayoutServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {   

        // config(['filesystems.public.url' =>  '/storage']); // can NOT use!

        // Publish assets
        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('laravellayout'),
        ], 'assets');

        // routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        
        // components
        $this->loadViewComponentsAs('laravelcomponent', [
            Components\Forminput::class, 
        ]);

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravellayout'); 

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
        $this->mergeConfigFrom(__DIR__.'/../config/laravellayout.php', 'laravellayout');

        // Register the service the package provides.
        $this->app->singleton('laravellayout', function ($app) {
            return new LaravelLayout;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravellayout'];
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
            __DIR__.'/../config/laravellayout.php' => config_path('laravellayout.php'),
        ], 'laravellayout.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/phonglg'),
        ], 'laravellayout.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/phonglg'),
        ], 'laravellayout.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/phonglg'),
        ], 'laravellayout.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}

<?php

namespace Phonglg\LaravelPost;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Phonglg\LaravelPost\Models\Post;
use Phonglg\LaravelPost\Policies\PostPolicy;

class LaravelPostServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    protected $policies = [ 
        Post::class => PostPolicy::class,  
    ];

    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'phonglg');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'phonglg');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->registerPolicies(); 
        // routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php'); 
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravelpost');
        
        
        //$this->loadMigrationsFrom(__DIR__ . '/../database/migrations');  

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
        $this->mergeConfigFrom(__DIR__.'/../config/laravelpost.php', 'laravelpost');

        // Register the service the package provides.
        $this->app->singleton('laravelpost', function ($app) {
            return new LaravelPost;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelpost'];
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
            __DIR__.'/../config/laravelpost.php' => config_path('laravelpost.php'),
        ], 'laravelpost.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/phonglg'),
        ], 'laravelpost.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/phonglg'),
        ], 'laravelpost.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/phonglg'),
        ], 'laravelpost.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}

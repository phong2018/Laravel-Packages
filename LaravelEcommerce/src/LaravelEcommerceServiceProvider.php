<?php

namespace Phonglg\LaravelEcommerce;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Phonglg\LaravelEcommerce\Models\Product;
use Phonglg\LaravelEcommerce\Policies\ProductPolicy;
use Phonglg\LaravelEcommerce\Models\Category;
use Phonglg\LaravelEcommerce\Policies\CategoryPolicy;

class LaravelEcommerceServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    protected $policies = [ 
        Product::class => ProductPolicy::class,
        Category::class => CategoryPolicy::class,
    ];
    
    public function boot(): void
    {

        $this->registerPolicies(); 
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravelecommerce');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');  
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
        $this->mergeConfigFrom(__DIR__.'/../config/laravelecommerce.php', 'laravelecommerce');

        // Register the service the package provides.
        $this->app->singleton('laravelecommerce', function ($app) {
            return new LaravelEcommerce;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelecommerce'];
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
            __DIR__.'/../config/laravelecommerce.php' => config_path('laravelecommerce.php'),
        ], 'laravelecommerce.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/phonglg'),
        ], 'laravelecommerce.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/phonglg'),
        ], 'laravelecommerce.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/phonglg'),
        ], 'laravelecommerce.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}

<?php

namespace Phonglg\LaravelVeso;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Phonglg\LaravelVeso\Models\Order;
use Phonglg\LaravelVeso\Models\Point;
use Phonglg\LaravelVeso\Models\Vesoproduct;
use Phonglg\LaravelVeso\Policies\AdminorderPolicy;
use Phonglg\LaravelVeso\Policies\AdminpointPolicy;
use Phonglg\LaravelVeso\Policies\VesoproductPolicy;
use Illuminate\Routing\Router;
use Phonglg\LaravelVeso\Http\Middleware\AdminMiddleware;
use Phonglg\LaravelVeso\Policies\AgencyorderPolicy;
use Phonglg\LaravelVeso\Providers\EventServiceProvider;

class LaravelVesoServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */

    // policies
    protected $policies = [ 
        Vesoproduct::class => VesoproductPolicy::class, 
        Order::class => AdminorderPolicy::class, 
        Point::class => AdminpointPolicy::class, 
    ];

    // registerGates
    public function registerGates(){
        // for admin
        Gate ::define('admin-updateOrderDetail', [AdminorderPolicy::class, 'updateOrderDetail']);
        Gate ::define('admin-updateOrderAddPoint', [AdminpointPolicy::class, 'updateOrderAddPoint']);
        Gate ::define('admin-updatePointAgency', [AdminpointPolicy::class, 'updatePointAgency']);

        // for agency
        Gate ::define('agency-updateOrderDetail', [AgencyorderPolicy::class, 'updateOrderDetail']);
    }

    // registerMiddleware
    public function registerMiddleware(){
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('adminMiddleware', AdminMiddleware::class);
    }

    public function boot(): void
    {
        $this->registerPolicies(); 
        $this->registerGates();
        $this->registerMiddleware();
        
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravelveso');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');  
        
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
        $this->app->register(EventServiceProvider::class);

        $this->mergeConfigFrom(__DIR__.'/../config/laravelveso.php', 'laravelveso');

        // Register the service the package provides.
        $this->app->singleton('laravelveso', function ($app) {
            return new LaravelVeso;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelveso'];
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
            __DIR__.'/../config/laravelveso.php' => config_path('laravelveso.php'),
        ], 'laravelveso.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/phonglg'),
        ], 'laravelveso.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/phonglg'),
        ], 'laravelveso.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/phonglg'),
        ], 'laravelveso.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}

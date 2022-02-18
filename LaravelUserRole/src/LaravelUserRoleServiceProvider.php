<?php

namespace Phonglg\LaravelUserRole;

use Illuminate\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Phonglg\LaravelUserRole\Models\Role;
use Phonglg\LaravelUserRole\Policies\RolePolicy;
use Phonglg\LaravelUserRole\Models\User;
use Phonglg\LaravelUserRole\Policies\UserPolicy; 
use Phonglg\LaravelUserRole\Models\Customer;
use Phonglg\LaravelUserRole\Policies\CustomerPolicy; 

class LaravelUserRoleServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    protected $policies = [ 
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
        Customer::class => CustomerPolicy::class
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        //Gate::define('update-custommer', [CustomerPolicy::class, 'update']);

        $this->publishes([
            __DIR__.'/../config/laraveluserrole.php' => config_path('laraveluserrole.php'),
        ]);

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laraveluserrole');
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
        $this->mergeConfigFrom(__DIR__.'/../config/laraveluserrole.php', 'laraveluserrole');

        // Register the service the package provides.
        $this->app->singleton('laraveluserrole', function ($app) {
            return new LaravelUserRole;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laraveluserrole'];
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
            __DIR__.'/../config/laraveluserrole.php' => config_path('laraveluserrole.php'),
        ], 'laraveluserrole.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/phonglg'),
        ], 'laraveluserrole.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/phonglg'),
        ], 'laraveluserrole.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/phonglg'),
        ], 'laraveluserrole.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}

<?php

namespace Phonglg\LaravelSetting;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Phonglg\LaravelSetting\Models\Setting;
use Phonglg\LaravelSetting\Policies\SettingPolicy;

class LaravelSettingServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    protected $policies = [ 
        Setting::class => SettingPolicy::class, 
    ];

    public function boot(): void
    {
        $this->registerPolicies();
        $this->publishes([
            __DIR__.'/../config/laravelsetting.php' => config_path('laravelsetting.php'),
        ]);

        //config('laravelsetting.database');
        $this->registerPolicies(); 
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravelsetting');
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
        $this->mergeConfigFrom(__DIR__.'/../config/laravelsetting.php', 'laravelsetting');

        // Register the service the package provides.
        $this->app->singleton('laravelsetting', function ($app) {
            return new LaravelSetting;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelsetting'];
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
            __DIR__.'/../config/laravelsetting.php' => config_path('laravelsetting.php'),
        ], 'laravelsetting.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/phonglg'),
        ], 'laravelsetting.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/phonglg'),
        ], 'laravelsetting.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/phonglg'),
        ], 'laravelsetting.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}

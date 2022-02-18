<?php

namespace Phonglg\LaravelFortify;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class LaravelFortifyServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravelfortify');
        
        // register View for Fortify
        $this->registerViewFortify();
        

        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'phonglg');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'phonglg');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

     //Features::registration()
    public function fortifyRegister(){
        // register /register
        Fortify::registerView(function () {
            return view('laravelfortify::auth.register');
        }); 
        // custome in: app\Actions\Fortify\CreateNewUser.php 
    }

    //Login
    public function fortifyLogin(){
        // login /login
        Fortify::loginView(function () {
            return view('laravelfortify::auth.login');
        });  
        
        // custom login // see orther method in: \vendor\laravel\fortify\src\Fortify.php
        Fortify::authenticateUsing(function (Request $request) {
            // dd($request);
            // can change by username by in \config\fortify.php:: 49: 'username' => 'username',
            $user = User::where('username', $request->username)->first();
            if ($user &&
                Hash::check($request->password, $user->password)) {
                return $user;
            } 
        });
    }

    // Features::resetPasswords(),
    public function fortifyForgotPassword(){ 
        // reset password /forgot-password (enter email to receil link reset password)
        Fortify::requestPasswordResetLinkView(function () {
            return view('laravelfortify::auth.passwords.email');
        });

        // enter news password
        Fortify::resetPasswordView(function ($request) {
            return view('laravelfortify::auth.passwords.reset', ['request' => $request]);
        });
    }

    
    // Features::updateProfileInformation(),
    public function fortifyProfileInformation(){
        // create: /profile/edit in packages\Phonglg\LaravelFortify\routes\web.php
        // option in \app\Actions\Fortify\UpdateUserProfileInformation.php
    }

    // Features::updatePasswords(),    
    public function fortifyProfilePassword(){
        // create /profile/password in packages\Phonglg\LaravelFortify\routes\web.php
        // option in \app\Actions\Fortify\UpdateUserPassword.php
    }

    // Features::emailVerification(),
    public function fortifyEmailVerification(){
        // guide: https://laravel.com/docs/8.x/fortify#email-verification
        // Route::get('/email/verify' name('verification.notice');
        // Route::post('/email/verification-notification' name('verification.send');
        // Route::get('/email/verify/{id}/{hash}' name('verification.verify');
        // check in middleware: \\wsl$\Ubuntu-20.04\home\source\laravel801\app\Http\Kernel.php::65
        // *** set laravel801\app\Models\User.php implements MustVerifyEmail
        Fortify::verifyEmailView(function ($request) {
            return view('laravelfortify::auth.verify', ['request' => $request]);
        });
    }

    public function fortifyTwoFactorAuthentication(){
        // // confirm password user/confirm-password
        Fortify::confirmPasswordView(function () {
            return view('laravelfortify::auth.passwords.confirm');
        });

        // two factor login
        Fortify::twoFactorChallengeView(function () {
            // need to use app: Authenticator in your mobile to get code
            return view('laravelfortify::auth.two-factor-challenge');
        });
    }

    public function registerViewFortify(){  
        $this->fortifyLogin();
        $this->fortifyRegister();
        $this->fortifyForgotPassword();
        $this->fortifyProfileInformation();
        $this->fortifyProfilePassword();
        $this->fortifyEmailVerification();
        $this->fortifyTwoFactorAuthentication(); 
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        // register laravelFortify
        $this->app->register(\App\Providers\FortifyServiceProvider::class);

        //----------
        $this->mergeConfigFrom(__DIR__.'/../config/laravelfortify.php', 'laravelfortify');

        // Register the service the package provides.
        $this->app->singleton('laravelfortify', function ($app) {
            return new LaravelFortify;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelfortify'];
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
            __DIR__.'/../config/laravelfortify.php' => config_path('laravelfortify.php'),
        ], 'laravelfortify.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/phonglg'),
        ], 'laravelfortify.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/phonglg'),
        ], 'laravelfortify.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/phonglg'),
        ], 'laravelfortify.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}

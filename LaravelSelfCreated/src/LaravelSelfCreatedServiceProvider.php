<?php

namespace Phonglg\LaravelSelfCreated;
use Illuminate\Support\ServiceProvider;
class LaravelSelfCreatedServiceProvider extends ServiceProvider{
    public function register(){
        
    }
    public function boot(){
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }
}
?>
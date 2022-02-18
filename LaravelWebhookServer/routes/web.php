<?php
use Illuminate\Support\Facades\Route;
use Spatie\WebhookServer\WebhookCall;

// use for app cotuong
Route::get('/LaravelWebhookServer', function () {
    return "laravel LaravelWebhookServer";
}); 

Route::get('/dispatchWebhook', function () {
    WebhookCall::create()
   ->url('http://localhost/webhook-receiving-url')
   ->payload(['key' => 'value of Key'])
   ->useSecret('mySerect')
   ->dispatch();
    //    ->dispatchSync();
}); 


 
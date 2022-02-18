<?php
 
use Illuminate\Support\Facades\Route;
use Phonglg\LaravelVeso\Controllers\WebhookController;
use Spatie\WebhookServer\WebhookCall;

// dont use just for test
Route::get('/dispatchWebhook', function () {
    WebhookCall::create()
   ->url('https://thantai39.vn/webhook-receiving-url')
   // ->url('http://localhost/webhook-receiving-url')
   ->payload(['key' => 'value of Key LARAVEL VESO IN THANTAI39'])
   ->useSecret('AppSecret')
   //->dispatch();
   ->dispatchSync();
});  

// https://thantai39.vn/webhook-receiving-result
Route::post('/webhook-receiving-result', [WebhookController::class, 'receivedWebhook'])->name('webhook.receivedWebhook');

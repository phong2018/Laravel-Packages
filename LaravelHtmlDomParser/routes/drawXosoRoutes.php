<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str; 
use Phonglg\LaravelHtmlDomParser\Controllers\ResetPrizeController;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoKenoEvent;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMax3DEvent;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMax3DProEvent;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMega645Event;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMienNamEvent;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMienTrungEvent;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMienBacEvent;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoPower655Event; 
use voku\helper\HtmlDomParser;
// use for app cotuong
Route::get('/LaravelHtmlDomParser', function () {
    return "laravel LaravelHtmlDomParser"; 
});

Route::get('/DrawXoSoMienNamEvent', function () {
    event(new DrawXoSoMienNamEvent()); 
});

Route::get('/DrawXoSoMienTrungEvent', function () {
    event(new DrawXoSoMienTrungEvent()); 
});

Route::get('/DrawXoSoMienBacEvent', function () {
    event(new DrawXoSoMienBacEvent()); 
});

Route::get('/DrawXoSoMega645Event', function () {
    event(new DrawXoSoMega645Event()); 
});

Route::get('/DrawXoSoPower655Event', function () {
    event(new DrawXoSoPower655Event()); 
});

Route::get('/DrawXoSoMax3DEvent', function () {
    event(new DrawXoSoMax3DEvent()); 
});

Route::get('/DrawXoSoMax3DProEvent', function () {
    event(new DrawXoSoMax3DProEvent()); 
});

Route::get('/DrawXoSoKenoEvent', function () {
    event(new DrawXoSoKenoEvent()); 
});

Route::get('/GetAllDataXoso', function () { 
    event(new DrawXoSoMienNamEvent());  
    event(new DrawXoSoMienTrungEvent());  
    event(new DrawXoSoMienBacEvent());  
    event(new DrawXoSoMega645Event());  
    event(new DrawXoSoPower655Event());  
    event(new DrawXoSoMax3DEvent());  
    event(new DrawXoSoMax3DProEvent());  
    event(new DrawXoSoKenoEvent()); 
});

// reset to get PeriodId for mega, power, max3d, max3dPro
Route::get('/ResetDataVietlott', [ResetPrizeController::class, 'ResetDataVietlott'])->name('prize.ResetDataVietlott');

 
<?php
 
use Illuminate\Support\Facades\Route;
use Phonglg\LaravelVeso\Controllers\Testing\BuyTicketTestController;
use Phonglg\LaravelVeso\Controllers\Testing\TestingController;
use Phonglg\LaravelVeso\Controllers\Testing\WinPrizeTestController;
 
Route::get('/testAll', [TestingController::class, 'testAll'])->name('testing.testAll');  
Route::get('/testWinPrize', [WinPrizeTestController::class, 'testWinPrize'])->name('winPrizeTest.testWinPrize');  
Route::get('/demoWinPrize', [WinPrizeTestController::class, 'demoWinPrize'])->name('winPrizeTest.demoWinPrize');  

Route::get('/testBuyTicket', [BuyTicketTestController::class, 'buyTicket'])->name('buyTicketTest.buyTicket');  

 
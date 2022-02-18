<?php

use Illuminate\Support\Facades\Route;
use Phonglg\LaravelVeso\Controllers\BuyLotteryController;

Route::get('/buyTraditionalLottery/{num?}', [BuyLotteryController::class, 'buyTraditionalLottery'])->name('buyLottery.buyTraditionalLottery'); 
Route::get('/buyMega645', [BuyLotteryController::class, 'buyMega645'])->name('buyLottery.buyMega645'); 
Route::get('/buyPower655', [BuyLotteryController::class, 'buyPower655'])->name('buyLottery.buyPower655'); 
Route::get('/buyMax3D', [BuyLotteryController::class, 'buyMax3D'])->name('buyLottery.buyMax3D'); 
Route::get('/buyMax3DPlus', [BuyLotteryController::class, 'buyMax3DPlus'])->name('buyLottery.buyMax3DPlus'); 
Route::get('/buyMax3DPro', [BuyLotteryController::class, 'buyMax3DPro'])->name('buyLottery.buyMax3DPro'); 
Route::get('/buyKeno', [BuyLotteryController::class, 'buyKeno'])->name('buyLottery.buyKeno');
 
Route::get('/notFound', [BuyLotteryController::class, 'notFound'])->name('notFound');  

 
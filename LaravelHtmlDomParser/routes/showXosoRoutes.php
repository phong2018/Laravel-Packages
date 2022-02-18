<?php

use Illuminate\Support\Facades\Route;
use Phonglg\LaravelHtmlDomParser\Controllers\PrizeController;

Route::get('/prizes', [PrizeController::class, 'index'])->name('prizes.index');
Route::get('/showAllPrizeByDate/{datePrize?}', [PrizeController::class, 'showAllPrizeByDate'])->name('prizes.showAllPrizeByDate');
Route::get('/showXosoMienNam/{prize_period?}', [PrizeController::class, 'showXosoMienNam'])->name('prizes.showXosoMienNam');
Route::get('/showXosoMienTrung/{prize_period?}', [PrizeController::class, 'showXosoMienTrung'])->name('prizes.showXosoMienTrung');
Route::get('/showXosoMienBac/{prize_period?}', [PrizeController::class, 'showXosoMienBac'])->name('prizes.showXosoMienBac');
Route::get('/showXosoMega645/{prize_period?}', [PrizeController::class, 'showXosoMega645'])->name('prizes.showXosoMega645');
Route::get('/showXosoPower655/{prize_period?}', [PrizeController::class, 'showXosoPower655'])->name('prizes.showXosoPower655');
Route::get('/showXosoMax3D/{prize_period?}', [PrizeController::class, 'showXosoMax3D'])->name('prizes.showXosoMax3D');
Route::get('/showXosoMax3DPro/{prize_period?}', [PrizeController::class, 'showXosoMax3DPro'])->name('prizes.showXosoMax3DPro');
Route::get('/showXosoKeno/{prize_period?}', [PrizeController::class, 'showXosoKeno'])->name('prizes.showXosoKeno');
Route::post('/getResultLottery/{prize_period?}', [PrizeController::class, 'getResultLottery'])->name('prizes.getResultLottery');





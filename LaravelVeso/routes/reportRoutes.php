<?php
 
use Illuminate\Support\Facades\Route;
use Phonglg\LaravelVeso\Controllers\Admin\AdminOrderController;
 

Route::get('/order/reportWinPrizes', [AdminOrderController::class, 'reportWinPrizes'])->name('order.reportWinPrizes');
Route::post('/order/updateAllWinPrize', [AdminOrderController::class, 'updateAllWinPrize'])->name('order.updateAllWinPrize');


 
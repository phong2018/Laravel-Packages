<?php

use Phonglg\LaravelVeso\Controllers\Admin\AdminOrderController;
use Illuminate\Support\Facades\Route; 

/* Add AdminOrderController routes */  
Route::get('/order/list/{fromDate?}/{toDate?}', [AdminOrderController::class, 'index'])->name('admin.order');  
Route::get('/order/{order}', [AdminOrderController::class, 'show'])->name('admin.order.show');  
Route::post('/updateOrderDetail', [AdminOrderController::class, 'updateOrderDetail'])->name('admin.updateOrderDetail');
Route::post('/updateWinPrizeVietlott', [AdminOrderController::class, 'updateWinPrizeVietlott'])->name('admin.updateWinPrizeVietlott');
Route::get('/listOrdersSaleVietlott', [AdminOrderController::class, 'listOrdersSaleVietlott'])->name('admin.listOrdersSaleVietlott');




 
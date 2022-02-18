<?php

use Phonglg\LaravelVeso\Controllers\Agency\AgencyOrderController;
use Illuminate\Support\Facades\Route; 
  
Route::get('agency/orderDetail/{orderDetail}/edit', [AgencyOrderController::class, 'editOrderDetail'])->name('agency.orderDetail.edit');  
Route::post('agency/updateWinPrize', [AgencyOrderController::class, 'updateWinPrize'])->name('agency.updateWinPrize'); 
Route::post('agency/getTicketToReturn', [AgencyOrderController::class, 'getTicketToReturn'])->name('agency.getTicketToReturn'); 
Route::post('agency/returnTicketForCustomer', [AgencyOrderController::class, 'returnTicketForCustomer'])->name('agency.returnTicketForCustomer');
Route::get('agency/listOrdersSale', [AgencyOrderController::class, 'listOrdersSale'])->name('agency.listOrdersSale');  


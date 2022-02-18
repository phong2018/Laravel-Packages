<?php

use Phonglg\LaravelVeso\Controllers\VesoproductController;
use Illuminate\Support\Facades\Route;
 
Route::get('/vesoproducts/list/{fromDate?}/{toDate?}', [VesoproductController::class, 'index'])->name('vesoproducts.index');
Route::get('/vesoproducts/agencyReport/{fromDate?}/{toDate?}', [VesoproductController::class, 'agencyReport'])->name('vesoproducts.agencyReport');
Route::get('/vesoproducts/create', [VesoproductController::class, 'create'])->name('vesoproducts.create');
Route::post('/vesoproducts/getHtmlProvince', [VesoproductController::class, 'getHtmlProvince'])->name('vesoproducts.getHtmlProvince');
Route::post('/vesoproducts/urlValidNumber', [VesoproductController::class, 'urlValidNumber'])->name('vesoproducts.urlValidNumber'); 
Route::post('/vesoproducts', [VesoproductController::class, 'store'])->name('vesoproducts.store');
Route::get('/vesoproducts/{vesoproduct}', [VesoproductController::class, 'edit'])->name('vesoproducts.show');
Route::get('/vesoproducts/{vesoproduct}/edit', [VesoproductController::class, 'edit'])->name('vesoproducts.edit');
Route::put('/vesoproducts/{vesoproduct}', [VesoproductController::class, 'update'])->name('vesoproducts.update');
Route::delete('/vesoproducts/{vesoproduct}', [VesoproductController::class, 'destroy'])->name('vesoproducts.destroy');
Route::post('/vesoproducts/{vesoproduct}/copy', [VesoproductController::class, 'copy'])->name('vesoproducts.copy');
Route::post('/deleteSelected', [VesoproductController::class, 'deleteSelected'])->name('vesoproducts.deleteSelected');
Route::post('/vesoproducts/unSoldTicket/{vesoproduct}', [VesoproductController::class, 'unSoldTicket'])->name('vesoproducts.unSoldTicket');
Route::post('/vesoproducts/unSoldAllTicket', [VesoproductController::class, 'unSoldAllTicket'])->name('vesoproducts.unSoldAllTicket');

//  for react
Route::get('/vesoproducts/react/sale', [VesoproductController::class, 'sale'])->name('vesoproducts.sale');
Route::post('/vesoproducts/react/saleTicket', [VesoproductController::class, 'saleTicket'])->name('vesoproducts.saleTicket');
Route::post('/vesoproducts/react/fetchTickets', [VesoproductController::class, 'fetchTickets'])->name('vesoproducts.fetchTickets');

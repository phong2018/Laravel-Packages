<?php
use Illuminate\Support\Facades\Route;
use Phonglg\LaravelTransaction\Controllers\TransactionController;

// LaravelSelfCreated
Route::get('/LaravelTransaction', function () {
    return "LaravelTransaction";
});
 
Route::group(['middleware' => ['web']], function () { 
    Route::get('/transaction/runSession', [TransactionController::class, 'runSession'])->name('transaction.runSession');
});
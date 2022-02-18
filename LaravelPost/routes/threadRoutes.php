<?php

use Phonglg\LaravelPost\Controllers\ThreadController;
use Illuminate\Support\Facades\Route;
 
Route::get('/thread/list', [ThreadController::class, 'index'])->name('thread.index');

Route::get('/thread/create', [ThreadController::class, 'create'])->name('thread.create');
Route::post('/thread', [ThreadController::class, 'store'])->name('thread.store');

Route::get('/thread/{thread}', [ThreadController::class, 'edit'])->name('thread.show');

Route::get('/thread/{thread}/edit', [ThreadController::class, 'edit'])->name('thread.edit');
Route::put('/thread/{thread}', [ThreadController::class, 'update'])->name('thread.update');
Route::post('/thread/{thread}/copy', [ThreadController::class, 'copy'])->name('thread.copy');

Route::delete('/thread/{thread}', [ThreadController::class, 'destroy'])->name('thread.destroy');
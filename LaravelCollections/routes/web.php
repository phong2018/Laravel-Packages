<?php

use Illuminate\Support\Facades\Route;
use Phonglg\LaravelCollections\Controllers\CollectionsController;

// use for app cotuong
Route::get('/LaravelCollections', function () {
    return "laravel LaravelCollections";
});

Route::group(['middleware' => ['web']], function () {  

    Route::get('collections/index',[CollectionsController::class,'index'])->name('collections.index');
    
    Route::get('collections/filter',[CollectionsController::class,'filter'])->name('collections.filter');

    Route::get('collections/pluck',[CollectionsController::class,'pluck'])->name('collections.pluck');

    Route::get('collections/contains',[CollectionsController::class,'contains'])->name('collections.contains');

    Route::get('collections/groupby',[CollectionsController::class,'groupby'])->name('collections.groupby');

    Route::get('collections/sortby',[CollectionsController::class,'sortby'])->name('collections.sortby');

    Route::get('collections/partition',[CollectionsController::class,'partition'])->name('collections.partition');

    Route::get('collections/reject',[CollectionsController::class,'reject'])->name('collections.reject');

    Route::get('collections/wherein',[CollectionsController::class,'wherein'])->name('collections.wherein');

    Route::get('collections/chunk',[CollectionsController::class,'chunk'])->name('collections.chunk');

    Route::get('collections/count',[CollectionsController::class,'count'])->name('collections.count');

    Route::get('collections/first',[CollectionsController::class,'first'])->name('collections.first');

    Route::get('collections/tap',[CollectionsController::class,'tap'])->name('collections.tap');
}); 


<?php 
use Illuminate\Support\Facades\Route;

// use for demo
Route::get('/vue', function () {
    return 'laravelVue Hello';
});

// use for study basic & hook
Route::get('/vue/study', function () {
    return view('laravelvue::vue.study');
});
 
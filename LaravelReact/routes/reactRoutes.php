<?php 
use Illuminate\Support\Facades\Route;

// use for demo
Route::get('/react', function () {
    return view('laravelreact::react.demo');
});

// use for study basic & hook
Route::get('/react/study', function () {
    return view('laravelreact::react.study');
});

// use for reactRender
Route::get('/react/reactRender', function () {
    return view('laravelreact::react.reactRender
    ');
});

// use for packages
Route::get('/react/packages', function () {
    return view('laravelreact::react.packages');
});

// use for formik
Route::get('/react/formik', function () {
    return view('laravelreact::react.formik');
});
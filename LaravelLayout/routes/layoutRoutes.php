<?php 
use Illuminate\Support\Facades\Route; 
 
// AdminLayout Route
Route::get('/admin01', function () {
    return view('laravellayout::layouts.templates.admin01.admin01');
}); 
Route::get('/admin02', function () {
    return view('laravellayout::layouts.templates.admin02.admin02');
});
Route::get('/admin03', function () {
    return view('laravellayout::layouts.templates.admin03.admin03');//ok
});

// HomeLayout Route
Route::get('/home00', function () {
    return view('laravellayout::layouts.templates.home00.home00');
});  
Route::get('/home01', function () {
    return view('laravellayout::layouts.templates.home01.home01');
}); 

//demoUseTailwind 
Route::get('/demoUseTailwind', function () {
    return view('laravellayout::layouts.templates.tailwind.demoUseTailwind');//ok
});

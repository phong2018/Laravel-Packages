<?php
use Illuminate\Support\Facades\Route;    
use Phonglg\LaravelPusher\Events\MessageNotification;
 

// use for app cotuong
Route::get('/laravelpusher', function () {
    return "laravel laravelpusher";
});


Route::group(['middleware' => ['web']], function () {   

    // sent event to pusher
    Route::get('/pusher', function () { 
        event(new MessageNotification('Xin chào Pusher Using React'));        
    });
    
    // use JavaScript listen event
    Route::get('/pusher/jquerylisten', function () {
       return view('laravelpusher::jqueryListen');
    });
    
    // use Reactjs listen event
    Route::get('/pusher/reactlisten', function () {
        return view('laravelpusher::reactListen');
     });    
}); 


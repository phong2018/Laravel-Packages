<?php
use Illuminate\Support\Facades\Route; 
use Phonglg\LaravelSockets\Events\MessageNotification;    
 

// use for app cotuong
Route::get('/laravelsocketsDemo', function () {
    return "laravel socket";
});


Route::group(['middleware' => ['web']], function () {   
    //sent event to laravelWebsocket
    Route::get('/laravelsockets', function () { 
        event(new MessageNotification('HELLO USING LARAVEL-WEBSOCKET'));
    }); 
    
    // use react to listen
    Route::get('/laravelsockets/reactlisten', function () {
        return view('laravelsockets::reactlisten');
     });
    
    // use laravelEcho  listen
    Route::get('/laravelsockets/laravelecholisten', function () {
        return view('laravelsockets::laravelEchoListen');
    });

    // use laravelEcho  JoiningPresenceChannels
    Route::get('/laravelsockets/JoiningPresenceChannels', function () {
        return view('laravelsockets::JoiningPresenceChannels');
    });
 
}); 

 


<?php 
use Illuminate\Support\Facades\Route;

// use for app cotuong
Route::get('/react/cotuong', function () {
    $data = array(
        'chessGameID' => '21312323hlhjkhkl',
        'playerID' => "adfadfdafrrwerwer",
        'tokenID' => "asdfaf2rwerwer"
    );
    return view('laravelreact::react.cotuong', ['data' => $data]);
});

// test return data
Route::get('/react/cotuong/getChessgameInfo', function () {
    return array(
        'chessgameInfo' => 'chessgameInfo Data',
        'hostInfo' => 'hostInfo Data',
        'competitorInfo' => 'CompetitorInfo Data',
        'rightToGoFirst' => '',
        'currRightToGo' => '',
        'currSelectedMan' => '',
        'roleInChessGame' => '',
    );
});


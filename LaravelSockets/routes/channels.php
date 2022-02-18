<?php

use Illuminate\Support\Facades\Broadcast;
 
Broadcast::channel('LaravelWebsocket.Chat', function ($user) {
    return $user;
});


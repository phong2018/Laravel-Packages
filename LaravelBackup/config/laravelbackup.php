<?php 
return [
    'name'=>'laravelbackup',
    'disk'=>[
        'driver' => 'local',
        'root' => storage_path('app/Laravel'),
    ]
];
 
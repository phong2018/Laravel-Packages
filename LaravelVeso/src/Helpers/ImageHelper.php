<?php

namespace Phonglg\LaravelVeso\Helpers;

use Illuminate\Support\Facades\File;

class ImageHelper
{
    public static function showThumbImg($path){
        $arg1 = pathinfo($path);  
        // echo $arg1['dirname'], "\n";
        // echo $arg1['basename'], "\n";
        // echo $arg1['extension'], "\n";
        // echo $arg1['filename'], "\n";
        return $arg1['dirname'].'/thumbs/'.$arg1['basename'];
        
    }
}
?>
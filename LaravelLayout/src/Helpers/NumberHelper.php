<?php

namespace Phonglg\LaravelLayout\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class NumberHelper
{
    public static function toNum($str){
        $num=str_replace([',','.'],"",$str);
        return $num;
    }

    public static function isNumber($num){
        if(is_numeric(NumberHelper::toNum($num)))
            return true;
        else return false; 
    }

    public static function round1bilion($number){

     


    }
}
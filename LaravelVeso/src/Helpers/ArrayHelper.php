<?php

namespace Phonglg\LaravelVeso\Helpers;

use Illuminate\Support\Facades\File; 
use Illuminate\Support\Carbon;

class ArrayHelper
{
    // get label form key of array[[key,value],[key,value],[key,value],...]
    // public static function getValueFromKeyCol($key,$arr,$colFind,$colResult){
    //   for($i=0;$i<count($arr);$i++)
    //   if ($key==$arr[$i][$colFind]) return $arr[$i][$colResult];
    //   return '';
    // } 

    public static function in2DArray($item,array $arr2D): bool{
        foreach($arr2D as $arr)
        foreach($arr as $val)
            if($val==$item) return true;
            
        return false;
    }

    public static function countIn2DArray($item,array $arr2D){
        $count=0;
        foreach($arr2D as $arr)
        foreach($arr as $val)
            if($val==$item) $count++;
            
        return $count;
    }
 
}
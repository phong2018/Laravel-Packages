<?php

namespace Phonglg\LaravelLayout\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class Date
{
    public static function getWeekdayFromDate($date)
    {
        return date('w', strtotime($date));
    } 

    // Y-m-d to d-m-Y
    public static function showDateDMY($date){  
        return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
    } 

    // d/m/Y||d-m-Y -> Y-m-d
    public static function dateDMYtoYMD($date){
        if($date[4]=='-') return $date;
        
        $resultDate=str_replace("/","-",$date); 
        $resultDate=Carbon::createFromFormat('d/m/Y', str_replace('-','/',$resultDate))->format('Y-m-d'); 
        return $resultDate;
    }
}
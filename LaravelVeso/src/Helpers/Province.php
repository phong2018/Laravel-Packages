<?php

namespace Phonglg\LaravelVeso\Helpers;

use Illuminate\Support\Facades\File;
use Phonglg\LaravelLayout\Helpers\Date;

class Province
{
    public static function getProvinces()
    {
        $provinces=[];
        foreach(config('laravelhtmldomparser.categoryType.miennam.provinces') as $slug=>$name)
        $provinces[]=  (object) [
            'slug'=>$slug.'|'.config('laravelhtmldomparser.categoryType.miennam.key'),
            'name'=>$name,
        ];
        
        foreach(config('laravelhtmldomparser.categoryType.mientrung.provinces') as $slug=>$name)
        $provinces[]=  (object) [
            'slug'=>$slug.'|'.config('laravelhtmldomparser.categoryType.mientrung.key'),
            'name'=>$name,
        ];
        foreach(config('laravelhtmldomparser.categoryType.mienbac.provinces') as $slug=>$name)
        $provinces[]=  (object) [
            'slug'=>$slug.'|'.config('laravelhtmldomparser.categoryType.mienbac.key'),
            'name'=>$name,
        ];

        return $provinces;
    }

    public static function getProvincesForCreateEdit($prize_date=-1)
    {
        if($prize_date==-1) $weekDate=Date::getWeekdayFromDate(date("Y-m-d"));
        else $weekDate=Date::getWeekdayFromDate($prize_date);

        $provinces=[];
        $provinces[]=  (object) [
            'slug'=>' ',
            'name'=>'***** Miền Nam *****',
        ];
        foreach(config('laravelhtmldomparser.categoryType.miennam.provinces') as $slug=>$name)
        if(in_array( $slug, config('laravelhtmldomparser.categoryType.miennam.datehasResult.'.$weekDate)))
        $provinces[]=  (object) [
            'slug'=>$slug.'|'.config('laravelhtmldomparser.categoryType.miennam.key'),
            'name'=>$name,
        ];
        
        $provinces[]=  (object) [
            'slug'=>' ',
            'name'=>'***** Miền Trung *****',
        ];
        foreach(config('laravelhtmldomparser.categoryType.mientrung.provinces') as $slug=>$name)
        if(in_array( $slug, config('laravelhtmldomparser.categoryType.mientrung.datehasResult.'.$weekDate)))
        $provinces[]=  (object) [
            'slug'=>$slug.'|'.config('laravelhtmldomparser.categoryType.mientrung.key'),
            'name'=>$name,
        ];

        $provinces[]=  (object) [
            'slug'=>' ',
            'name'=>'***** Miền Bắc *****',
        ];
        foreach(config('laravelhtmldomparser.categoryType.mienbac.provinces') as $slug=>$name)
        if(in_array( $slug, config('laravelhtmldomparser.categoryType.mienbac.datehasResult.'.$weekDate)))
        $provinces[]=  (object) [
            'slug'=>$slug.'|'.config('laravelhtmldomparser.categoryType.mienbac.key'),
            'name'=>$name,
        ];

        return $provinces;
    }

    public static function getProvincesByKey(){
        $temProvinces=Province::getProvinces(); $provinces=[];
        foreach($temProvinces as $val){
            $tempArr=explode('|',$val->slug);
            $provinces[$tempArr[0]]=$val->name;
        } 
        return $provinces;
    }



    public static function getMienFromProvice($province)
    {
    }
    
 
}
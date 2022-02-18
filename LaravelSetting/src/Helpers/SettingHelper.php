<?php

namespace Phonglg\LaravelSetting\Helpers;

use voku\helper\HtmlDomParser;
use Illuminate\Support\Str;
use Phonglg\LaravelSetting\Models\Setting;

class SettingHelper
{
    // get key
    public static function getKey($key){
        $row=Setting::where('key',$key)->first();
        if($row)
            if($row['serialized']==1)// check json array
                return json_decode($row['value']);
            else return $row['value'];
        else return null;
    }

    // set key
    public static function setKey($key,$value,$serialized,$name='',$category=''){
        $row=Setting::where('key',$key)->first();

        if($serialized==1)// check json array
            $value=json_encode($value);

        if($row) $row->update(['value' => $value]);
        else
            Setting::create([
                'name'=>$name,
                'key'=>$key,
                'value'=>$value,
                'serialized'=>$serialized,
                'category'=>$category
            ]); 
    }
}
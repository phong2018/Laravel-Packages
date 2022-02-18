<?php

namespace Phonglg\LaravelHtmlDomParser\Helpers;

use Carbon\Carbon;  
use Phonglg\LaravelLayout\Helpers\Date;
use Illuminate\Support\Facades\Log; 
use Phonglg\LaravelSetting\Helpers\SettingHelper;

class HtmlDomParserHelper
{
    // getHtmlFromUrl
    public static function getHtmlFromUrl($url){
        // guide: https://stackoverflow.com/questions/38891690/php-cannot-get-the-text-from-an-url-file-get-content-curl-did-not-work?rq=1
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'thantai39');
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_TIMEOUT_MS,10);
        //curl_setopt($ch, CURLOPT_TIMEOUT,2);
        $result = curl_exec($ch);
        curl_close($ch); 
        return $result;
        // $html=HtmlDomParser::str_get_html($result);
        // $wrapperKQKeno=$html->find('.chitietketqua_title b')[0]->plaintext;
        // dd($wrapperKQKeno);
    }
 

    // checkNeedDrawForTraditonal
    public static function checkNeedDrawForTraditonal($keyLatestResult){
        $currDate=date('Y-m-d');
        $latestResultDate=SettingHelper::getKey($keyLatestResult);
        if($currDate==$latestResultDate)return false;
        else return true; 
    }

    // checkNeedDrawForVietLott
    public static function checkNeedDrawForVietLott($categoryType){ 
        
        $currDate=date('Y-m-d');
        $weekday=Date::getWeekdayFromDate($currDate); 
        $weekdaysHasReults=config('laravelhtmldomparser.categoryType.'.$categoryType.'.weekdays');

        // if not in weekdaysHasReults -> false
        if(!in_array($weekday, $weekdaysHasReults)) return false;
        else{// check exist 
            $latestResultDate=SettingHelper::getKey(config('laravelhtmldomparser.categoryType.'.$categoryType.'.keyLatestResult'));
            if($latestResultDate==null) return true;
            else // check need to update
                if($currDate==$latestResultDate[1]) return false; 
                else return true; 
        } 
    }

    // checkNeedDrawForTraditonal
    public static function checkNeedDrawForKeno(){
        $currDate=date('Y-m-d');
        $currTime=date('H');
        $currMinute=date('i');
        for($i=10;$i<=60;$i=$i+10)
        if($currMinute<=$i) break;
        if($i==10) $i='00';else $i=$i-10;
        $currTime.=':'.$i;
        //-------
        $latestResultDate=SettingHelper::getKey(config('laravelhtmldomparser.categoryType.keno.keyLatestResult'));
        //Log::debug($latestResultDate,[$currDate,$currTime]);

        if($latestResultDate==null) return true;
        else
            if($currDate==$latestResultDate[1] && $currTime==$latestResultDate[2])return false;
            else return true; 
    }
}
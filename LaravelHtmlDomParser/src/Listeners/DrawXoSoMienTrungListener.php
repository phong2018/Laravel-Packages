<?php

namespace Phonglg\LaravelHtmlDomParser\Listeners;
 
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMienTrungEvent;  
use Phonglg\LaravelHtmlDomParser\Helpers\GetTraditionalPrizeHelper;
use Phonglg\LaravelHtmlDomParser\Helpers\HtmlDomParserHelper; 

class DrawXoSoMienTrungListener
{ 

    public function handle(DrawXoSoMienTrungEvent $event)
    { 
        if(HtmlDomParserHelper::checkNeedDrawForTraditonal(config('laravelhtmldomparser.categoryType.mientrung.keyLatestResult'))){
            $url = "https://www.minhchinh.com/user/tpltructiep.php?mien=3";
            $traditionalType=config('laravelhtmldomparser.categoryType.mientrung.key');
            $result=GetTraditionalPrizeHelper::getResultTraditional($url); 
            GetTraditionalPrizeHelper::saveResultTraditional($result,$traditionalType);
            Log::debug('Mien Trung chưa co => LAY');
        }else{
            Log::debug('Mien Trung co roi => KHONG');
        }
    }
}


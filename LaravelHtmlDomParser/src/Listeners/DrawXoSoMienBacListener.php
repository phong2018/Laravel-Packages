<?php

namespace Phonglg\LaravelHtmlDomParser\Listeners;
 
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMienBacEvent;  
use Phonglg\LaravelHtmlDomParser\Helpers\GetTraditionalPrizeHelper;
use Phonglg\LaravelHtmlDomParser\Helpers\HtmlDomParserHelper; 

class DrawXoSoMienBacListener
{ 

    public function handle(DrawXoSoMienBacEvent $event)
    {  
        if(HtmlDomParserHelper::checkNeedDrawForTraditonal(config('laravelhtmldomparser.categoryType.mienbac.keyLatestResult'))){
            $url = "https://www.minhchinh.com/user/tpltructiep.php?mien=2";
            $traditionalType=config('laravelhtmldomparser.categoryType.mienbac.key');
            $result=GetTraditionalPrizeHelper::getResultTraditional($url); 
            GetTraditionalPrizeHelper::saveResultTraditional($result,$traditionalType);
            Log::debug('Mien Bac chưa co => LAY');
        }else{
            Log::debug('Mien Bac co roi => KHONG');
        }
    }
}


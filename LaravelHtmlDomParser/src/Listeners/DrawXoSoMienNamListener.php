<?php

namespace Phonglg\LaravelHtmlDomParser\Listeners;
 
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMienNamEvent;  
use Phonglg\LaravelHtmlDomParser\Helpers\GetTraditionalPrizeHelper;
use Phonglg\LaravelHtmlDomParser\Helpers\HtmlDomParserHelper; 

class DrawXoSoMienNamListener
{ 
    public function handle(DrawXoSoMienNamEvent $event)
    {  
        if(HtmlDomParserHelper::checkNeedDrawForTraditonal(config('laravelhtmldomparser.categoryType.miennam.keyLatestResult'))){
            $url = "https://www.minhchinh.com/user/tpltructiep.php?mien=1";
            $traditionalType=config('laravelhtmldomparser.categoryType.miennam.key');
            $result=GetTraditionalPrizeHelper::getResultTraditional($url); 
            GetTraditionalPrizeHelper::saveResultTraditional($result,$traditionalType);
            Log::debug('Mien nam chưa co => LAY');
        }else{
            Log::debug('Mien nam co roi => KHONG');
        }
    }
}


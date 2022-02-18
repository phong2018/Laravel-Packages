<?php

namespace Phonglg\LaravelHtmlDomParser\Listeners;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMega645Event;  
use Phonglg\LaravelHtmlDomParser\Helpers\HtmlDomParserHelper;
use Phonglg\LaravelHtmlDomParser\Traits\GetResultVietlottMinhChinhTraits; 

class DrawXoSoMega645Listener
{
    use GetResultVietlottMinhChinhTraits;

    public function handle(DrawXoSoMega645Event $event)
    { 
        $vietlottType=config('laravelhtmldomparser.categoryType.mega645.key'); 
        if(HtmlDomParserHelper::checkNeedDrawForVietLott($vietlottType)){
            $url='https://www.minhchinh.com/livekqxs/xstt/t_mega645.php';
            $result=$this->getResultVietlottMegaPower($vietlottType,$url);
            $this->saveResultVietlott($vietlottType,$result);   
            Log::debug('maga645 chưa co => LAY');
        }else{
            Log::debug('maga645 co roi => KHONG');
        } 
    }
}


<?php

namespace Phonglg\LaravelHtmlDomParser\Listeners;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoPower655Event;  
use Phonglg\LaravelHtmlDomParser\Helpers\HtmlDomParserHelper;
use Phonglg\LaravelHtmlDomParser\Traits\GetResultVietlottMinhChinhTraits;  

class DrawXoSoPower655Listener
{
    use GetResultVietlottMinhChinhTraits;

    public function handle(DrawXoSoPower655Event $event)
    { 
        $vietlottType=config('laravelhtmldomparser.categoryType.power655.key');
        if(HtmlDomParserHelper::checkNeedDrawForVietLott($vietlottType)){
            $url='https://www.minhchinh.com/livekqxs/xstt/t_power655.php';
            $result=$this->getResultVietlottMegaPower($vietlottType,$url);
            $this->saveResultVietlott($vietlottType,$result);   
            Log::debug('power655 chưa co => LAY');
        }else{
            Log::debug('power655 co roi => KHONG');
        } 
    } 
}


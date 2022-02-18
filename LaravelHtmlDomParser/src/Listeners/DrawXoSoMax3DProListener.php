<?php

namespace Phonglg\LaravelHtmlDomParser\Listeners;
 
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMax3DProEvent;  
use Phonglg\LaravelHtmlDomParser\Helpers\HtmlDomParserHelper;
use Phonglg\LaravelHtmlDomParser\Traits\GetResultVietlottMinhChinhTraits;  

class DrawXoSoMax3DProListener
{  
    use GetResultVietlottMinhChinhTraits; 

    public function handle(DrawXoSoMax3DProEvent $event)
    { 
        $vietlottType=config('laravelhtmldomparser.categoryType.max3dpro.key');
        if(HtmlDomParserHelper::checkNeedDrawForVietLott($vietlottType)){
            $url='https://www.minhchinh.com/livekqxs/xstt/t_max3dpro.php';
            $result=$this->getResultVietlottMax3D($vietlottType,$url);
            $this->saveResultVietlott($vietlottType,$result);
            Log::debug('max3dpro chưa co => LAY');
        }else{
            Log::debug('max3dpro co roi => KHONG');
        } 
        
    }
}

 
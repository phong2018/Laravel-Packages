<?php

namespace Phonglg\LaravelHtmlDomParser\Listeners;
 
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMax3DEvent;  
use Phonglg\LaravelHtmlDomParser\Helpers\HtmlDomParserHelper;
use Phonglg\LaravelHtmlDomParser\Traits\GetResultVietlottMinhChinhTraits; 

class DrawXoSoMax3DListener
{  
    use GetResultVietlottMinhChinhTraits ;

    public function handle(DrawXoSoMax3DEvent $event)
    { 
        $vietlottType=config('laravelhtmldomparser.categoryType.max3d.key');
        if(HtmlDomParserHelper::checkNeedDrawForVietLott($vietlottType)){
            $url='https://www.minhchinh.com/livekqxs/xstt/t_max3d.php';
            $result=$this->getResultVietlottMax3D($vietlottType,$url);
            $this->saveResultVietlott($vietlottType,$result);   
            Log::debug('max3d chưa co => LAY');
        }else{
            Log::debug('max3d co roi => KHONG');
        } 
    }
}


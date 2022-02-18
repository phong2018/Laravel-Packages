<?php

namespace Phonglg\LaravelHtmlDomParser\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller; 
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoKenoEvent;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMax3DEvent;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMax3DProEvent;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMega645Event;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMienBacEvent;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMienNamEvent;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoMienTrungEvent;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoPower655Event;
use Phonglg\LaravelHtmlDomParser\Traits\GetResultVietlottTraits;
use Phonglg\LaravelLayout\Helpers\Date;

class ResetPrizeController extends Controller
{  
    use GetResultVietlottTraits;
    // ResetDataVietlott
    public function ResetDataVietlott(){
          //mega645
          $vietlottType=config('laravelhtmldomparser.categoryType.mega645.key'); 
          $url='https://vietlott.vn/vi/trung-thuong/ket-qua-trung-thuong/645';
          $result=$this->getResultVietlott($vietlottType,$url);
          $this->saveResultVietlott($vietlottType,$result);   
          Log::debug('reset mega645');

          //power655
          $vietlottType=config('laravelhtmldomparser.categoryType.power655.key');
          $url='https://vietlott.vn/vi/trung-thuong/ket-qua-trung-thuong/655';
          $result=$this->getResultVietlott($vietlottType,$url);
          $this->saveResultVietlott($vietlottType,$result);   
          Log::debug('reset power655');

          //max3d
          $vietlottType=config('laravelhtmldomparser.categoryType.max3d.key');
          $url='https://vietlott.vn/vi/trung-thuong/ket-qua-trung-thuong/max-3d';
          $result=$this->getResultVietlott($vietlottType,$url,'#divMax3D tbody tr');
          $this->saveResultVietlott($vietlottType,$result);   
          Log::debug('reset max3d');

          // max3dpro
          $vietlottType=config('laravelhtmldomparser.categoryType.max3dpro.key');
          $url='https://vietlott.vn/vi/trung-thuong/ket-qua-trung-thuong/max-3dpro';
          $result=$this->getResultVietlott($vietlottType,$url);
          $this->saveResultVietlott($vietlottType,$result);
          Log::debug('reset max3dpro');

          // draw data
          event(new DrawXoSoMienNamEvent());  
          event(new DrawXoSoMienTrungEvent());  
          event(new DrawXoSoMienBacEvent());  
          event(new DrawXoSoMega645Event());  
          event(new DrawXoSoPower655Event());  
          event(new DrawXoSoMax3DEvent());  
          event(new DrawXoSoMax3DProEvent());  
          event(new DrawXoSoKenoEvent()); 
    }
}


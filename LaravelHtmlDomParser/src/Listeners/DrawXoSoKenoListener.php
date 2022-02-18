<?php

namespace Phonglg\LaravelHtmlDomParser\Listeners;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelHtmlDomParser\Events\DrawXoSoKenoEvent; 
use Phonglg\LaravelHtmlDomParser\Models\Prize;
use voku\helper\HtmlDomParser;
use Illuminate\Support\Str;
use Phonglg\LaravelHtmlDomParser\Helpers\HtmlDomParserHelper;
use Phonglg\LaravelLayout\Helpers\NumberHelper;
use Phonglg\LaravelSetting\Helpers\SettingHelper;
use Phonglg\LaravelVeso\Services\WinPrizeServices;

class DrawXoSoKenoListener
{
    private $html;
    private $result=[];  

    // getXoSoKeno
    public function getKetQuaXoSoKeno__OLD(){
        $url = "https://www.minhchinh.com/xo-so-dien-toan-keno.html"; // url to getKetQuaXoSoKeno
        $htmlContent=HtmlDomParserHelper::getHtmlFromUrl($url);
        $this->html=HtmlDomParser::str_get_html($htmlContent); 
        $this->result= [];// var save KetQuaXoSoKeno
        $wrapperKQKeno=$this->html->find('.wrapperKQKeno');
        if(!isset($wrapperKQKeno[0])) $this->result=null;
        else{
            $wrapperKQKeno=$wrapperKQKeno[0];
            $this->result['kyKQKeno']=$wrapperKQKeno->find('.kyKQKeno')[0]->plaintext; // get prize_date
            $this->result['timeKQ']=$wrapperKQKeno->find('.timeKQ div')->plaintext; // get prize_date 
            $this->result['timeKQ']=Str::replace('/', '-', $this->result['timeKQ']);
            $this->result['boxKQKeno']=$wrapperKQKeno->find('.boxKQKeno div')->plaintext; // get prize_date  
        }
        // dd($this->result);
    }

    // getKetQuaXoSoKeno
    public function getKetQuaXoSoKeno(){
        $url = "https://www.minhchinh.com/livekqxs/xstt/t_keno.php"; // url to getKetQuaXoSoKeno
        $htmlContent=HtmlDomParserHelper::getHtmlFromUrl($url);
        $this->html=HtmlDomParser::str_get_html($htmlContent); 
        $this->result= [];// var save KetQuaXoSoKeno
        $tempResult=$this->html->find('tbody tr')[0]; 
        $tempResult=$tempResult->find('td');  
        //---substr(string,start,length)
        $this->result['kyKQKeno']=substr($tempResult[0]->plaintext,0,7); // get prize_period
        $this->result['timeKQ']=$tempResult[1]->find('div')->plaintext; // get prize_date 
        $this->result['timeKQ']=Str::replace('/', '-', $this->result['timeKQ']);
        foreach($tempResult as $no=>$td)
        if($no>1) $this->result['boxKQKeno'][]=$tempResult[$no]->plaintext;
        //----
        $tempResult=$this->html->find('tbody tr')[1]; 
        $tempResult=$tempResult->find('td'); 
        foreach($tempResult as $no=>$td)
        $this->result['boxKQKeno'][]=$tempResult[$no]->plaintext;
        // dd($this->result);
    }

    // save data into Prize
    public function saveKetQuaXoSoKeno(){ 
        if($this->result){
            $prize_date=Carbon::parse($this->result['timeKQ'][0])->format('Y-m-d'); 
            $prize_time=$this->result['timeKQ'][1];
            $keyPrize=str_replace('-','',$prize_date).str_replace(':','',$this->result['timeKQ'][1]).Str::slug(config('laravelhtmldomparser.categoryType.keno.key'));
            $fields=[
                'key'=>$keyPrize,
                'category'=>config('laravelhtmldomparser.categoryType.keno.key'),
                'prize_date'=>$prize_date,
                'prize_time'=>$prize_time,
                'prize_period'=>$this->result['kyKQKeno'],
                'prize_number'=>collect($this->result['boxKQKeno'])->toJson(),
                'prize_value'=>'',
                'status'=>1,
            ]; 

            // get checkFinishedDraw
            $checkFinishedDraw=true;
            foreach($this->result['boxKQKeno'] as $num) 
            if(!(NumberHelper::isNumber($num))){$checkFinishedDraw=false;break;} 

            if ($checkFinishedDraw && Prize::where('key', $keyPrize)->count()==0){// check not exist to create
                $prize=Prize::create($fields); 
                $categorySetting=config('laravelsetting.categories');
                SettingHelper::setKey(config('laravelhtmldomparser.categoryType.keno.keyLatestResult'),[$this->result['kyKQKeno'],$prize_date.' '.$prize_time],1,'latestResultKeno',$categorySetting[2]->key);
                // update WinPrize for orderDetail
                $service=new WinPrizeServices();
                $service->CheckWinPrize($prize);
            }
        }
    }

    public function handle(DrawXoSoKenoEvent $event)
    { 
        if(HtmlDomParserHelper::checkNeedDrawForKeno()){
            $this->getKetQuaXoSoKeno();  
            $this->saveKetQuaXoSoKeno();
            Log::debug('keno chưa co => LAY');
        }else{
            Log::debug('keno co roi => KHONG');
        } 
    }
}


<?php

namespace Phonglg\LaravelHtmlDomParser\Helpers;

use Carbon\Carbon;  
use Phonglg\LaravelLayout\Helpers\Date;
use Illuminate\Support\Facades\Log; 
use Phonglg\LaravelSetting\Helpers\SettingHelper;
use voku\helper\HtmlDomParser;
use Illuminate\Support\Str;
use Phonglg\LaravelHtmlDomParser\Models\Prize;
use Phonglg\LaravelLayout\Helpers\NumberHelper;
use Phonglg\LaravelVeso\Services\WinPrizeServices;

class GetTraditionalPrizeHelper
{ 
    public static function getResultTraditional($url){ 
        $htmlContent=HtmlDomParserHelper::getHtmlFromUrl($url);
        $html=HtmlDomParser::str_get_html($htmlContent); 
        $result= [];
        $prize_date= $html->find('.ngaykqxs')[0]->plaintext;
        $prize_date=substr($prize_date,strlen($prize_date)-10,10);
        $prize_date=str_replace("/","-",$prize_date);
        if(!isset($prize_date)) $result=null;
        else {
            $result['prize_date']=$prize_date; // get prize_date
            $box_kqxs=$html->find('.bangkqxs'); // get table data content kqxs
            $result['provinces']=$box_kqxs->find('.tentinh')->plaintext; // get provinces
            $result['ticketTypes']=$box_kqxs->find('.loaive')->plaintext; // get provinces
            $result['prizes']=[];
            $result['prizes'][]=$box_kqxs->find('.giai_dac_biet div')->plaintext; 
            $result['prizes'][]=$box_kqxs->find('.giai_nhat div')->plaintext;
            $result['prizes'][]=$box_kqxs->find('.giai_nhi div')->plaintext;
            $result['prizes'][]=$box_kqxs->find('.giai_ba div')->plaintext;
            $result['prizes'][]=$box_kqxs->find('.giai_tu div')->plaintext;
            $result['prizes'][]=$box_kqxs->find('.giai_nam div')->plaintext;
            $result['prizes'][]=$box_kqxs->find('.giai_sau div')->plaintext;
            $result['prizes'][]=$box_kqxs->find('.giai_bay div')->plaintext;
            $result['prizes'][]=$box_kqxs->find('.giai_tam div')->plaintext; // get prizes
        } 
        return $result;
    }

    // handleGetProvinceForMienBac
    public static function handleGetProvinceForMienBac(){
        $weekDay=date('w',time());
        $provincesMienBac=config('laravelhtmldomparser.categoryType.mienbac.provincesHasResult');
        return [$provincesMienBac[$weekDay]];
    }

    public static function saveResultTraditional($result,$traditonalType){
        // $result['prizes'][0][2]=''; 
        if($result){

            $prize_date=Carbon::parse($result['prize_date'])->format('Y-m-d'); 
            $currDate=date('Y-m-d');
            if($prize_date!=$currDate) return false;//dd($prize_date,$currDate); 
            
            $prize_value=config('laravelhtmldomparser.categoryType.'.$traditonalType.'.prizes');
            $numberPrize=config('laravelhtmldomparser.categoryType.'.$traditonalType.'.numberPrize');
            // get prize into every provinces
            $checkFinishedDraw=true;
            $allPrizes=[];
            $prize_number=[];
            $countProvinces=count($result['provinces']);

            for($i=0;$i<$numberPrize;$i++){
                $prizes=$result['prizes'][$i];  
                $prizesTemp=collect($prizes)->split($countProvinces);
                for($j=0;$j<$countProvinces;$j++)
                $prize_number[$j][]=$prizesTemp[$j];
                // check $checkFinishedDraw 
                foreach($prizes as $prize) 
                if(!(NumberHelper::isNumber($prize))){$checkFinishedDraw=false;break;} 
            } 

            // handle for XosoMienBac
            if($traditonalType==config('laravelhtmldomparser.categoryType.mienbac.key'))
            $result['provinces']=GetTraditionalPrizeHelper::handleGetProvinceForMienBac(); 

            // save data every province 
            foreach($result['provinces'] as $province_order=>$province){
                $keyPrize=Str::slug(str_replace('-','',$prize_date).$province);
                $fields=[
                    'key'=>$keyPrize,
                    'category'=>config('laravelhtmldomparser.categoryType.'.$traditonalType.'.key'),
                    'prize_date'=>$prize_date,
                    'prize_number'=>collect($prize_number[$province_order])->toJson(),
                    'province'=>$province,
                    'prize_ticketType'=>isset($result['ticketTypes'][$province_order])?$result['ticketTypes'][$province_order]:'',
                    'prize_period'=>strtotime($prize_date),
                    'prize_value'=>collect($prize_value)->toJson(),
                    'status'=>1,
                ]; 
                // create/update Prize
                $prize=Prize::where('key', $keyPrize)->first();
                if($prize) $prize->update($fields);
                else $prize=Prize::create($fields);   
                // get allPrizes for every MienBac|MienNam|MienTrung
                $allPrizes[]=$prize;
            } 

            // checkFinishedDraw
            if($checkFinishedDraw){
                // update WinPrize for orderDetail
                $service=new WinPrizeServices();
                foreach($allPrizes as $prize) $service->CheckWinPrize($prize);                

                // set LatestResult for setting
                $categorySetting=config('laravelsetting.categories');
                SettingHelper::setKey(config('laravelhtmldomparser.categoryType.'.$traditonalType.'.keyLatestResult'),$prize_date,0,'latestResult'.$traditonalType,$categorySetting[2]->key);
            }  
        } 
    }
     
  
}
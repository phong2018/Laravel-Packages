<?php

namespace  Phonglg\LaravelHtmlDomParser\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;

use Phonglg\LaravelHtmlDomParser\Helpers\HtmlDomParserHelper;
use Phonglg\LaravelHtmlDomParser\Models\Prize;
use Phonglg\LaravelLayout\Helpers\Date;
use Phonglg\LaravelLayout\Helpers\NumberHelper;
use Phonglg\LaravelSetting\Helpers\SettingHelper;
use Phonglg\LaravelVeso\Helpers\Vietlott;
use Phonglg\LaravelVeso\Services\WinPrizeServices;
use voku\helper\HtmlDomParser;

trait GetResultVietlottMinhChinhTraits
{
  // getResultVietlott for MegaPower
  public function getResultVietlottMegaPower($vietlottType,$url){ 

    $htmlContent=HtmlDomParserHelper::getHtmlFromUrl($url);
    $html=HtmlDomParser::str_get_html($htmlContent);
    $result= [];
    // get date
    $prize_date= $html->find('.ngay');
    if(isset($prize_date[0])){
        $prize_date= $prize_date[0]->plaintext;
        $prize_date=substr($prize_date,strlen($prize_date)-10,10);
        // date form d/m/Y -> Y-m-d
        $result['prize_date']=Date::dateDMYtoYMD($prize_date); 
        $result['prize_period']= Vietlott::getLatestPeriod($vietlottType,$result['prize_date']);  

        // get chitietketqua_table result prize
        $tempResult=$html->find('.table_vietlott tbody tr');     
        
        foreach($tempResult as $no=>$row){
            $valRow=$row->find('td'); 
            if(isset($valRow[3])){
              $result['prize_name'][$no]=html_entity_decode($valRow[0]->plaintext);
              $result['prize_number'][$no]=$valRow[1]->plaintext; 
              $result['prize_quantity'][$no]=$valRow[2]->plaintext;
              $result['prize_value'][$no]=$valRow[3]->plaintext;
            } 
        } 

        // specify for mega645 
        if($vietlottType==config('laravelhtmldomparser.categoryType.mega645.key')){
          $result['prize_number'][$no+1]=$html->find('.box_ketqua span')->plaintext; 
        } 
        
        // specify for power655 
        if($vietlottType==config('laravelhtmldomparser.categoryType.power655.key')){
          $result['prize_number'][$no]=$html->find('.box_ketqua span')->plaintext; 
        } 
    } 
    // dd($result);
    return $result;
  }

  // getResultVietlott for Max3D
  public function getResultVietlottMax3D($vietlottType,$url){ 

    $htmlContent=HtmlDomParserHelper::getHtmlFromUrl($url);
    $html=HtmlDomParser::str_get_html($htmlContent);
    $result= [];  
    // get date
    $daymonth=$html->find('.daymonth');
    if(isset($daymonth[0])){
        $daymonth=$daymonth[0]->plaintext;
        $year=$html->find('.year')[0]->plaintext;
        $prize_date=  $daymonth.'/'.$year;
        $prize_date=substr($prize_date,strlen($prize_date)-10,10);
        $result['prize_date']=Date::dateDMYtoYMD($prize_date); 
        $result['prize_period']= Vietlott::getLatestPeriod($vietlottType,$result['prize_date']);    
        
        // get chitietketqua_table result prize
        $tempResult=$html->find('.table_max3d tbody tr');     

        foreach($tempResult as $no=>$row){
            $valRow=$row->find('td'); 
            $result['prize_name'][$no]=html_entity_decode($valRow[0]->plaintext);
            $result['prize_number'][$no]=$valRow[1]->find('div')->plaintext;  
            if(count($result['prize_number'][$no])==0)
            $result['prize_number'][$no]=$valRow[1]->find('span')->plaintext;  
            
            // specify for max3DPro
            if($vietlottType==config('laravelhtmldomparser.categoryType.max3dpro.key')){ 
              $result['prize_quantity'][$no]=$valRow[3]->plaintext;
              $result['prize_value'][$no]=$valRow[2]->plaintext;
            } 
        } 
        // specify for max3D
        if($vietlottType==config('laravelhtmldomparser.categoryType.max3d.key')){ 
            // update name
            $result['prize_name'][0]='Đặc biệt';
            $result['prize_name'][1]='Giải Nhất';
            $result['prize_name'][2]='Giải Nhì';
            $result['prize_name'][3]='Giải Ba';
            // get giaithuong, soluong
            $tempResult=$html->find('.table_slmax3d tbody tr');     
            foreach($tempResult as $no=>$row)
            if($no>0){
                $valRow=$row->find('td'); 
                if(isset($valRow[3])){
                  $result['prize_value'][$no-1]=html_entity_decode($valRow[0]->plaintext);
                  $result['prize_quantity'][$no-1]=$valRow[1]->plaintext;  
                } 
            } 
        }  
    }  
    // dd($result);
    return $result;
  }

  // save data into Prize
  public function saveResultVietlott($vietlottType,$result){  
      if($result){
          
          $keyPrize=str_replace('-','',$result['prize_date']).$vietlottType;
          $fields=[
              'key'=>$keyPrize,
              'category'=>$vietlottType,
              'prize_date'=>$result['prize_date'],
              'prize_period'=>$result['prize_period'],
              'prize_name'=>json_encode($result['prize_name']),
              'prize_number'=>json_encode($result['prize_number']),  
              'prize_quantity'=>json_encode($result['prize_quantity']),
              'prize_value'=>json_encode($result['prize_value']),
              'status'=>config('laravelveso.prizeStatus.active.value'),
          ]; 
          // handle for $checkFinishedDraw
          $checkFinishedDraw=true;
          // specify for mega645 
          if($vietlottType==config('laravelhtmldomparser.categoryType.mega645.key')){
            foreach($result['prize_number'][4] as $num)  // check prize_number
            if(!(NumberHelper::isNumber($num))) {$checkFinishedDraw=false;break;} 
            foreach($result['prize_quantity'] as $num)  // check prize_quantity
            if(!(NumberHelper::isNumber($num))) {$checkFinishedDraw=false;break;} 
             // check prize_value
            if(!(NumberHelper::isNumber($result['prize_value'][0]))) $checkFinishedDraw=false;
          } 
          // specify for power655 
          if($vietlottType==config('laravelhtmldomparser.categoryType.power655.key')){
            foreach($result['prize_number'][5] as $num)  
            if(!(NumberHelper::isNumber($num))){$checkFinishedDraw=false;break;}

            foreach($result['prize_quantity'] as $num)  // check prize_quantity
            if(!(NumberHelper::isNumber($num))) {$checkFinishedDraw=false;break;} 
             // check prize_value
            if(!(NumberHelper::isNumber($result['prize_value'][0])) || !(NumberHelper::isNumber($result['prize_value'][1]))) $checkFinishedDraw=false;
          }  
          // specify for max3D // dd($result);
          if($vietlottType==config('laravelhtmldomparser.categoryType.max3d.key')){ 
            foreach($result['prize_number'] as $no=>$nums) // check prize_number
            if($no<=3){ // have number result
              foreach($nums as $num)
              if(!(NumberHelper::isNumber($num))) {$checkFinishedDraw=false;break;}
            }else break;
            // check prize_quantity
            foreach($result['prize_quantity'] as $no=>$num)
            if($no<=3){if(!(NumberHelper::isNumber($num))) {$checkFinishedDraw=false;break;}}
            else break;
          }
          
          // specify for max3DPro // dd($result);
          if($vietlottType==config('laravelhtmldomparser.categoryType.max3dpro.key')){ 
            foreach($result['prize_number'] as $no=>$nums) // check prize_number
            if($no<=3){ // have number result
              foreach($nums as $num)
              if(!(NumberHelper::isNumber($num))) {$checkFinishedDraw=false;break;}
            }else break;
            
            // check prize_quantity
            foreach($result['prize_quantity'] as $no=>$num)
            if(!(NumberHelper::isNumber($num))) {$checkFinishedDraw=false;break;}
          }

          // create/ update prize
          $prize = Prize::where('key', $keyPrize)->first();
          if($prize) $prize->update($fields);
          else $prize=Prize::create($fields); 

          // checkFinishedDraw
          if($checkFinishedDraw){
              // update WinPrize for orderDetail
              $service=new WinPrizeServices();
              $service->CheckWinPrize($prize); 
              
              // set LatestResult for setting
              $categorySetting=config('laravelsetting.categories');
              SettingHelper::setKey(config('laravelhtmldomparser.categoryType.'.$vietlottType.'.keyLatestResult'),[$result['prize_period'],$result['prize_date']],1,'latestResult '.$vietlottType,$categorySetting[2]->key);
          }

          //dd($result,$checkFinishedDraw);
      }
  }
}
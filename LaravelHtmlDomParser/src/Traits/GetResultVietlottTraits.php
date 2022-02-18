<?php

namespace  Phonglg\LaravelHtmlDomParser\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;

use Phonglg\LaravelHtmlDomParser\Helpers\HtmlDomParserHelper;
use Phonglg\LaravelHtmlDomParser\Models\Prize;
use Phonglg\LaravelSetting\Helpers\SettingHelper;
use voku\helper\HtmlDomParser;

trait GetResultVietlottTraits
{
  // getResultVietlott
  public function getResultVietlott($vietlottType,$url,$selector='.chitietketqua_table tbody tr'){ 

    $htmlContent=HtmlDomParserHelper::getHtmlFromUrl($url);
    $html=HtmlDomParser::str_get_html($htmlContent);
    $result= [];
    // get chitietketqua_title infoLottery period & date
    $infoLottery=$html->find('.chitietketqua_title b'); 

    if(!isset($infoLottery[0]) || !isset($infoLottery[1])) return null;
    // get info vietlott
    $result['prize_period']=$infoLottery[0]->plaintext; 
    $result['prize_date']=$infoLottery[1]->plaintext; 
    // get chitietketqua_table result prize
    $detailResult=$html->find($selector);        
    foreach($detailResult as $no=>$row){
        $valRow=$row->find('td');
        $result['prize_name'][$no]=$valRow[0]->plaintext;
        $result['prize_number'][$no]=$valRow[1]->plaintext; 
        $result['prize_quantity'][$no]=$valRow[2]->plaintext;
        $result['prize_value'][$no]=$valRow[3]->plaintext;
    }

    // specify for mega645 & power655 
    if($vietlottType==config('laravelhtmldomparser.categoryType.mega645.key') || $vietlottType==config('laravelhtmldomparser.categoryType.power655.key')){
      $result['prize_number'][$no+1]= $html->find('.day_so_ket_qua .bong_tron')->plaintext; 
    }

    // specify for max3d 
    if($vietlottType==config('laravelhtmldomparser.categoryType.max3d.key')){ 
      for($i=0;$i<=$no;$i++){
        $temp=$result['prize_number'][$i];
        $temp=str_replace(" ","",$temp);
        $temp=str_replace("&nbsp;"," ",$temp);
        $temp=explode(" ",$temp); 
        $result['prize_number'][$i]=[];
        foreach($temp as $num) if($num)$result['prize_number'][$i][]=$num;
      }
    } 
    // dd($result['prize_number']);
    // specify for max3dpro 
    if($vietlottType==config('laravelhtmldomparser.categoryType.max3dpro.key')){ 
      for($i=0;$i<=$no;$i++){
          $temp=$result['prize_number'][$i]; 
          $result['prize_number'][$i]=[];
          $positonNum= strripos($temp,'ba số');
          if($positonNum>0){
            $temp=preg_replace('/\s+/', ' ', $temp);  
            $lengthNum=strlen($temp);  
            $positonNum=$positonNum+7; 
            $result['prize_number'][$i][]=substr($temp,0,$positonNum);
            $result['prize_number'][$i][]=substr($temp,$positonNum+1,$lengthNum-$positonNum);
          }else{
            $result['prize_number'][$i][]='';
            $result['prize_number'][$i][]=$temp;
          }
          $temp=$result['prize_number'][$i];
          $result['prize_number'][$i]=[];
          foreach($temp as $num) if($num)$result['prize_number'][$i][]=$num;
      } 
    }  

    return $result;
  }

  // save data into Prize
  public function saveResultVietlott($vietlottType,$result){ 
      if($result){
          $result['prize_date']=Carbon::createFromFormat('d/m/Y', str_replace('-','/',$result['prize_date']))->format('Y-m-d');
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

          // create/ update prize 
          $prize = Prize::where('key', $keyPrize)->first();
          if($prize) $prize->update($fields);
          else Prize::create($fields); 
          
          $categorySetting=config('laravelsetting.categories');
          SettingHelper::setKey(config('laravelhtmldomparser.categoryType.'.$vietlottType.'.keyLatestResult'),[$result['prize_period'],$result['prize_date']],1,'latestResult '.$vietlottType,$categorySetting[2]->key);
      }
  }
}
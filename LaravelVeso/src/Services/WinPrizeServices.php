<?php
namespace Phonglg\LaravelVeso\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelHtmlDomParser\Models\Prize;
use Phonglg\LaravelLayout\Helpers\Date;
use Phonglg\LaravelLayout\Helpers\NumberHelper;
use Phonglg\LaravelVeso\Helpers\ArrayHelper;
use Phonglg\LaravelVeso\Helpers\Vietlott;
use Phonglg\LaravelVeso\Models\Order;
use Phonglg\LaravelVeso\Models\Orderdetail;
use Phonglg\LaravelVeso\Models\WinPrize;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Phonglg\LaravelSetting\Helpers\SettingHelper;
use Phonglg\LaravelVeso\Helpers\LockPoint;
use Phonglg\LaravelVeso\Helpers\TraditionalTicket;
use Phonglg\LaravelVeso\Notifications\WinPrizeNotifications;


// $winPrizes[$i]=[$labelPrize,$tempPrizeValue,$prize->category,0,$quantityWin];
// ................ labelPrize  PrizeValue     category        status  qtyTicket

class WinPrizeServices{

    // check WinPrize
    public function CheckWinPrize(Prize $prize){
        
        // Log::debug('CheckWinPrize: '.$prize); 
      
        if($prize->status!=config('laravelveso.prizeStatus.checkedForOrder.value') || 1==1){
            $prize->update(['status'=>config('laravelveso.prizeStatus.checkedForOrder.value')]);
            // dd($prize->category);
            switch ($prize->category){
                case config('laravelhtmldomparser.categoryType.miennam.key'):
                    $this->CheckWinPrizeTraditional($prize); 
                    break;
                case config('laravelhtmldomparser.categoryType.mientrung.key'):
                    $this->CheckWinPrizeTraditional($prize); 
                    break;
                case config('laravelhtmldomparser.categoryType.mienbac.key'):
                    $this->CheckWinPrizeTraditional($prize); 
                    break;
                case config('laravelhtmldomparser.categoryType.mega645.key'):
                    $this->CheckWinPrizeMega645($prize); 
                    break;
                case config('laravelhtmldomparser.categoryType.power655.key'):
                    $this->CheckWinPrizePower655($prize); 
                    break;
                case config('laravelhtmldomparser.categoryType.max3d.key'):
                    $this->CheckWinPrizeMax3D($prize); 
                    $this->CheckWinPrizeMax3DPlus($prize); 
                    break;
                case config('laravelhtmldomparser.categoryType.max3dpro.key'):
                    $this->CheckWinPrizeMax3DPro($prize); 
                    break;
                case config('laravelhtmldomparser.categoryType.keno.key'):
                    $this->CheckWinPrizeKeno($prize); 
                    break;
            }
        } 
    }

    // getQuantityWin
    public function getQuantityWin($game_type,$prizeIndex,$quantityBuy){
        if($quantityBuy==0) return 0;

        if($game_type==config('laravelhtmldomparser.categoryType.traditionallottery.gameType.vethuong.key'))
            return $quantityBuy;   
        else{ // capnguyen
            if($prizeIndex==0 || $prizeIndex==10) return 11; // 11 DBTicket || DBPhu
            else if($prizeIndex==11) return 99; //prize of Agency 
                 else return 110;  //110 #Ticket
        }  
    }

    // checkWinForPrizeTraditional
    public function checkWinForPrizeTraditional($prizeNumber,$numTicket,$prizeIndex,$game_type){
        if($game_type==config('laravelhtmldomparser.categoryType.traditionallottery.gameType.vethuong.key')
            || $prizeIndex>0 ){ 
               // Log::debug($prizeNumber.'--'.$numTicket);
               return $prizeNumber==$numTicket;
            }
        else{ // DB capnguyen
            $tempPrizeNumber=substr($prizeNumber,1,5);
            $tempNumTicket=substr($numTicket,1,5); 
            return $tempPrizeNumber==$tempNumTicket;
        }
        
    }

    // CheckWinKKTraditional
    public function CheckWinKKTraditional($prizeNumber,$numberTicket,$gameType){
        if($gameType==config('laravelhtmldomparser.categoryType.traditionallottery.gameType.vethuong.key')){
            for($i=1;$i<6;$i++){
                $tempPrizeNumber=substr($prizeNumber,0,$i).substr($prizeNumber,$i+1);
                $tempNumberTicket=substr($numberTicket,0,$i).substr($numberTicket,$i+1);
                if($tempPrizeNumber==$tempNumberTicket) return true;
            }
        }else{ // capnguyen
            for($i=1;$i<6;$i++){
                $tempPrizeNumber=substr($prizeNumber,1,$i-1).substr($prizeNumber,$i+1);
                $tempNumberTicket=substr($numberTicket,1,$i-1).substr($numberTicket,$i+1);
                if($tempPrizeNumber==$tempNumberTicket) return true;
            } 
        }
        return false;
    }

    // testing
    public function testTing($temp){
        dump('tempValue: ',$temp);
        if($temp==0) return 0;
        else return $temp*2;
    }

    // CheckWinPrizeTraditional
    public function CheckWinPrizeTraditional(Prize $prize):void{
        // get prize Info
        $keyPrize=$prize->key;  
        $prizeNumbers=json_decode($prize->prize_number); 
        $valuePrizes=json_decode($prize->prize_value);
        $countPrizes=count($valuePrizes);
        $constCountPrizes=$countPrizes;
        $vethuongKey=config('laravelhtmldomparser.categoryType.traditionallottery.gameType.vethuong.key');
        $capnguyenKey=config('laravelhtmldomparser.categoryType.traditionallottery.gameType.capnguyen.key');
        // get orderDetails depend on Prize
        $orderDetails=Orderdetail::where('details_key',$keyPrize)->get();
        foreach($orderDetails as $orderDetail){ 
            $details=json_decode($orderDetail->details); 
            // check not yet check Winprize
            if(!isset($details->winPrizes)){
                $tempName=explode("|",$details->name);
                $numberTicket=$tempName[0];
                Log::debug('so: '.$numberTicket);
                $winPrizes=[]; 
                $checkWinPrize=false;
                $countPrizes=$constCountPrizes; 
                // Check Prize 0..8
                for($i=0;$i<$constCountPrizes;$i++){  
                    $winPrizes[$i]=null; 
                    $lengthNumberPrize=strlen($prizeNumbers[$i][0]);
                    $numTicket=substr($numberTicket,6-$lengthNumberPrize,$lengthNumberPrize); 
                    foreach($prizeNumbers[$i] as $prizeNumber)
                    if($this->checkWinForPrizeTraditional($prizeNumber,$numTicket,$i,$details->game_type)){
                        $quantityBuy=$orderDetail->quantity-$orderDetail->quantity_refund;
                        $quantityWin=$this->getQuantityWin($details->game_type,$i,$quantityBuy);
                        $tempPrizeValue=$valuePrizes[$i]*$quantityWin;
                        $labelPrize=config('laravelhtmldomparser.prizeOrder.'.$i).' ('.$quantityWin.' vé)';
                        $winPrizes[$i]=[$labelPrize,$tempPrizeValue,$prize->category,0,$quantityWin];
                        $checkWinPrize=true; 
                        break;
                    } 
                } 
                // check DBPhu for CapNguyen
                if($winPrizes[0]!==null && $details->game_type==$capnguyenKey){
                    $quantityBuy=$orderDetail->quantity-$orderDetail->quantity_refund;
                    if($quantityBuy==0)$quantityWin=0;
                    else $quantityWin=99;
                    $labelPrize=config('laravelhtmldomparser.prizeOrder.9.0').' ('.$quantityWin.' vé)';;
                    $tempPrizeValue=config('laravelhtmldomparser.prizeOrder.9.1')*$quantityWin;
                    $winPrizes[$countPrizes]=[$labelPrize,$tempPrizeValue,$prize->category,0,$quantityWin];
                    $checkWinPrize=true; 
                    $countPrizes++;
                }
                
                // check DBPhu for Vethuong
                if($winPrizes[0]==null && $details->game_type==$vethuongKey){ 
                    $tempPrizeNumber=substr($prizeNumbers[0][0],1,5); 
                    $tempNumTicket=substr($numberTicket,1,5); 
                    if($tempPrizeNumber==$tempNumTicket){
                        $quantityBuy=$orderDetail->quantity-$orderDetail->quantity_refund;
                        $quantityWin=$this->getQuantityWin($details->game_type,9,$quantityBuy);

                        $labelPrize=config('laravelhtmldomparser.prizeOrder.9.0').' ('.$quantityWin.' vé)';;
                        $tempPrizeValue=config('laravelhtmldomparser.prizeOrder.9.1')*$quantityWin;
                        $winPrizes[$countPrizes]=[$labelPrize,$tempPrizeValue,$prize->category,0,$quantityWin];
                        $checkWinPrize=true;
                        $countPrizes++;
                    }
                }
                // check KK 
                if($winPrizes[0]==null){ 
                    if($this->CheckWinKKTraditional($prizeNumbers[0][0],$numberTicket,$details->game_type)){
                        $quantityBuy=$orderDetail->quantity-$orderDetail->quantity_refund;
                        $quantityWin=$this->getQuantityWin($details->game_type,10,$quantityBuy);
                        $labelPrize=config('laravelhtmldomparser.prizeOrder.10.0').' ('.$quantityWin.' vé)';
                        $tempPrizeValue=config('laravelhtmldomparser.prizeOrder.10.1')*$quantityWin; 
                        $winPrizes[$countPrizes]=[$labelPrize,$tempPrizeValue,$prize->category,0,$quantityWin];
                        $checkWinPrize=true; 
                        $countPrizes++;
                    }
                } 

                // if not winPrize && quanlityBuy>=2, check extra winPrize duplicate 2,3,4 in Prize ĐB
                if(!$checkWinPrize && (($orderDetail->quantity-$orderDetail->quantity_refund>=2) || $details->game_type==$capnguyenKey)){
                    // 4num
                    $last4NumTicket=substr($numberTicket,2,4); 
                    $last4NumPrizeDB=substr($prizeNumbers[0][0],2,4); 
                    if($last4NumTicket==$last4NumPrizeDB){//same 4 last DBPrize
                        $quantityBuy=$orderDetail->quantity-$orderDetail->quantity_refund;
                        $quantityWin=$this->getQuantityWin($details->game_type,11,$quantityBuy);
                        $tempPrizeValue=config('laravelhtmldomparser.extraPrize.last4NumPrizeDB.value')*$quantityWin;
                        $labelPrize=config('laravelhtmldomparser.extraPrize.last4NumPrizeDB.label').' ('.$quantityWin.' vé)';
                        $winPrizes[$countPrizes]=[$labelPrize,$tempPrizeValue,$prize->category,0,$quantityWin];
                        $checkWinPrize=true;
                        Log::debug('handle last4NumPrizeDB');
                    }  
                    else{ // 3num
                        $last3NumTicket=substr($numberTicket,3,3); 
                        $last3NumPrizeDB=substr($prizeNumbers[0][0],3,3); 
                        if($last3NumTicket==$last3NumPrizeDB){//same 3 last DBPrize
                            $quantityBuy=$orderDetail->quantity-$orderDetail->quantity_refund;
                            $quantityWin=$this->getQuantityWin($details->game_type,12,$quantityBuy);
                            $tempPrizeValue=config('laravelhtmldomparser.extraPrize.last3NumPrizeDB.value')*$quantityWin;
                            $labelPrize=config('laravelhtmldomparser.extraPrize.last3NumPrizeDB.label').' ('.$quantityWin.' vé)';
                            // check for Capnguyen
                            if($details->game_type==$capnguyenKey){
                                $tempPrizeValue=config('laravelhtmldomparser.extraPrize.last3NumPrizeDB.valueForCapNguyen');
                                $labelPrize=config('laravelhtmldomparser.extraPrize.last3NumPrizeDB.label');
                            } 

                            $winPrizes[$countPrizes]=[$labelPrize,$tempPrizeValue,$prize->category,0,$quantityWin]; 
                            $checkWinPrize=true;
                            Log::debug('handle last3NumPrizeDB');
                        } 
                        else{//same 2 last DBPrize
                            
                            $last2NumTicket=substr($numberTicket,4,2); 
                            $last2NumPrizeDB=substr($prizeNumbers[0][0],4,2); 
                            Log::debug($numberTicket.'---'.$last2NumTicket.'--'.$last2NumPrizeDB);

                            if($last2NumTicket==$last2NumPrizeDB){//same 2 last DBPrize
                                $quantityBuy=$orderDetail->quantity-$orderDetail->quantity_refund;
                                $quantityWin=$this->getQuantityWin($details->game_type,13,$quantityBuy);

                                $checkWinPrize=true;
                                $labelPrize=config('laravelhtmldomparser.extraPrize.last2NumPrizeDB.label'); 
                                $tempPrizeValue=config('laravelhtmldomparser.extraPrize.last2NumPrizeDB.key');
                                $winPrizes[$countPrizes]=[$labelPrize,$tempPrizeValue,$prize->category,0,$quantityWin];
                                Log::debug('handle last2NumPrizeDB');
                            } 
                        }
                    } 
                }
                // update winPrizess for Order & OrderDetail
                $details->winPrizes=$winPrizes;  
                Vietlott::updateWinPrizeForOrder($orderDetail,$details,$checkWinPrize);
            }
        } 
    }
    // CheckWinPrizeMega645
    public function CheckWinPrizeMega645(Prize $prize):void{
        // get prize Info
        $keyPrize=$prize->category.$prize->prize_period;  
        $arrPrizeNumbers=json_decode($prize->prize_number); 
        $prizeNumbers=$arrPrizeNumbers[4];
        $valuePrizes=config('laravelhtmldomparser.categoryType.mega645.prizesValue');
        // get orderDetails depend on Prize
        $orderDetails=Orderdetail::where('details_key','like','%'.$keyPrize.'%')->get();
        // handle every orderDetail
        foreach($orderDetails as $orderDetail){ 
            Vietlott::tickDetailsKeyVietlott($orderDetail,$keyPrize); 
            $details=json_decode($orderDetail->details); 
            // check not yet check Winprize  
            $blocksNumbers=$details->blocksNumber; 
            $periodStatus=$details->periodStatus;
            $specificPeriods=$details->specificPeriods;
            $methodSelected=$details->methodSelected;
            //dd(gettype($details->winPrizes));
            if(isset($details->winPrizes)) $winPrizes=(array)$details->winPrizes;
            else $winPrizes=[];
            $checkWinPrize=false; 
            // handle ever period
            foreach($specificPeriods as $noPeriod=>$specificPeriod){
                $tempPeriod=explode('|',$specificPeriod);
                $period=trim($tempPeriod[0]); 
                // if samePeriod & periodSuccess && notYetCheckPeriod
                if($period==$prize->prize_period && $periodStatus[$noPeriod]==config('laravelveso.buyingPeriodsStatus.success.0')){   
                    foreach($blocksNumbers as $noBlock=>$blocksNumber){
                        if($blocksNumber){// check every block
                            $duplicateNum=0;
                            foreach($blocksNumber as $num)
                            if(in_array($num,$prizeNumbers))$duplicateNum++;

                            $tempValPrize=$valuePrizes[$methodSelected][$duplicateNum];
                            $labelPrizeName='Trúng '.$duplicateNum.' số';
                            
                            if($tempValPrize!=''){
                                $checkWinPrize=true;
                                $tempValPrize=$tempValPrize;
                                Log::debug('$winPrizes',$winPrizes);
                                $winPrizes[$noPeriod][$noBlock][]=[$labelPrizeName,$tempValPrize,$prize->category,0,1];
                            }  
                            else $winPrizes[$noPeriod][$noBlock][]=null;
                        }
                        else $winPrizes[$noPeriod][$noBlock][]=null;
                    }                     
                }
                else $winPrizes[$noPeriod][]=null;
            }
            $details->winPrizes=$winPrizes;  
            Vietlott::updateWinPrizeForOrder($orderDetail,$details,$checkWinPrize); 
        } 
    }
    // CheckWinPrizePower655
    public function CheckWinPrizePower655(Prize $prize):void{
        // get prize Info 
        $keyPrize=$prize->category.$prize->prize_period;  
        $arrPrizeNumbers=json_decode($prize->prize_number); 
        $prizeNumbers=$arrPrizeNumbers[5];
        $lastPrizeNumbers=$prizeNumbers[6];
        array_pop($prizeNumbers);
        $valuePrizes=config('laravelhtmldomparser.categoryType.power655.prizesValue');
        // get orderDetails depend on Prize
        $orderDetails=Orderdetail::where('details_key','like','%'.$keyPrize.'%')->get();
        // handle every orderDetail
        foreach($orderDetails as $orderDetail){ 

            Vietlott::tickDetailsKeyVietlott($orderDetail,$keyPrize);  

            $details=json_decode($orderDetail->details); 
            // check not yet check Winprize  
            $blocksNumbers=$details->blocksNumber; 
            $periodStatus=$details->periodStatus;
            $specificPeriods=$details->specificPeriods;
            $methodSelected=$details->methodSelected;
            //dd(gettype($details->winPrizes));
            if(isset($details->winPrizes)) $winPrizes=(array)$details->winPrizes;
            else $winPrizes=[];
            $checkWinPrize=false; 
            
            // handle ever period
            foreach($specificPeriods as $noPeriod=>$specificPeriod){
                $tempPeriod=explode('|',$specificPeriod);
                $period=trim($tempPeriod[0]); 
                
                // if samePeriod & periodSuccess && notYetCheckPeriod
                if($period==$prize->prize_period && $periodStatus[$noPeriod]==config('laravelveso.buyingPeriodsStatus.success.0')){  
                    foreach($blocksNumbers as $noBlock=>$blocksNumber){
                        if($blocksNumber){// check every block
                            $duplicateNum=0;
                            $duplicateLastNum=0;
                            $tempValPrize='';
                            $labelPrizeName='';

                            foreach($blocksNumber as $num)
                            if(in_array($num,$prizeNumbers))$duplicateNum++;
                            if(in_array($lastPrizeNumbers,(array)$blocksNumber)) $duplicateLastNum++;  
                            Log::debug('blocksNumber: ',(array)$blocksNumber);
                            Log::debug('$duplicateLastNum:'.$duplicateLastNum);
                            Log::debug('$duplicateNum:'.$duplicateNum);
                            // handle get prizeIndex  
                            if($methodSelected==1){//bao5
                                switch($duplicateNum){
                                    case 5: 
                                        $tempValPrize=$valuePrizes[$methodSelected][5];
                                        $labelPrizeName=$tempValPrize;
                                        break;
                                    case 4:
                                        if($duplicateLastNum>0){ //TRÚNG 4 SỐ + BONUS NUMBER
                                            $tempValPrize=$valuePrizes[$methodSelected][6];
                                            $labelPrizeName=$tempValPrize;
                                        }
                                        else{ //chỉ TRÚNG 4 SỐ
                                            $tempValPrize=$valuePrizes[$methodSelected][4];
                                            $labelPrizeName='Trúng 4 số';
                                        } 
                                        break;
                                    default:
                                        $tempValPrize=$valuePrizes[$methodSelected][$duplicateNum];
                                        $labelPrizeName='Trúng '.$duplicateNum.' số';
                                } 
                            }else{//don&bao#
                                switch($duplicateNum){
                                    case 6: 
                                        if($duplicateLastNum>0) $tempValPrize=$valuePrizes[$methodSelected][8];
                                        else $tempValPrize=$valuePrizes[$methodSelected][6];
                                        $labelPrizeName=$tempValPrize;
                                        break; 
                                    case 5:
                                        if($duplicateLastNum>0){
                                            $tempValPrize=$valuePrizes[$methodSelected][7];
                                            $labelPrizeName=$tempValPrize;
                                        }
                                        else{
                                            $tempValPrize=$valuePrizes[$methodSelected][5];
                                            $labelPrizeName='Trúng 5 số';
                                        } 
                                        break;
                                    default:
                                        $tempValPrize=$valuePrizes[$methodSelected][$duplicateNum];
                                        $labelPrizeName='Trúng '.$duplicateNum.' số';
                                }
                            } 
                            // winPrizes
                            if($tempValPrize!=''){
                                $checkWinPrize=true; 
                                $winPrizes[$noPeriod][$noBlock][]=[$labelPrizeName,$tempValPrize,$prize->category,0,1];
                            } 
                            else $winPrizes[$noPeriod][$noBlock][]=null;
                        }
                        else $winPrizes[$noPeriod][$noBlock][]=null;
                    }                     
                }
                else $winPrizes[$noPeriod][]=null;
            }
            $details->winPrizes=$winPrizes;  
            Vietlott::updateWinPrizeForOrder($orderDetail,$details,$checkWinPrize); 
        } 
    }
    // CheckWinPrizeMax3D
    public function CheckWinPrizeMax3D(Prize $prize):void{
        // get prize Info 
        $keyPrize=$prize->category.$prize->prize_period;  
        $prizeNumbers=json_decode($prize->prize_number);   
        $valuePrizes=config('laravelhtmldomparser.categoryType.max3d.prizesValue'); 
        $countPrizes=count($valuePrizes);
        // get orderDetails depend on Prize
        $orderDetails=Orderdetail::where('details_key','like','%'.$keyPrize.'%')->get();
        // handle every orderDetail
        foreach($orderDetails as $orderDetail){ 

            Vietlott::tickDetailsKeyVietlott($orderDetail,$keyPrize);  

            $details=json_decode($orderDetail->details); 
            // check not yet check Winprize  
            $blocksNumbers=$details->blocksNumber; 
            $periodStatus=$details->periodStatus;
            $priceBlocks=$details->priceBlocks;
            $specificPeriods=$details->specificPeriods;
            //dd(gettype($details->winPrizes));
            if(isset($details->winPrizes)) $winPrizes=(array)$details->winPrizes;
            else $winPrizes=[];
            $checkWinPrize=false; 
            
            // handle ever period
            foreach($specificPeriods as $noPeriod=>$specificPeriod){
                $tempPeriod=explode('|',$specificPeriod);
                $period=trim($tempPeriod[0]);  

                // if samePeriod & periodSuccess && notYetCheckPeriod
                if($period==$prize->prize_period && $periodStatus[$noPeriod]==config('laravelveso.buyingPeriodsStatus.success.0')){  
                    foreach($blocksNumbers as $noBlock=>$blocksNumber){
                        if($blocksNumber){// check every block  
                            $numTicket=$blocksNumber[0];  
                            $checkWinPrizeforNoBlock=false;
                            for($i=0;$i<$countPrizes;$i++){ //i=0 
                                if(in_array($numTicket,$prizeNumbers[$i])){
                                    Log::debug('$valuePrizes[$i]:');
                                    Log::debug($valuePrizes[$i]);
                                    Log::debug($priceBlocks[$noBlock]);
                                    $checkWinPrizeforNoBlock=true;
                                    $tempValPrize=NumberHelper::toNum($valuePrizes[$i])*$priceBlocks[$noBlock]/10000; 
                                    $prizesName=config('laravelhtmldomparser.categoryType.max3d.prizesName.'.$i);
                                    $checkWinPrize=true; 
                                    $winPrizes[$noPeriod][$noBlock][]=[$prizesName,$tempValPrize,$prize->category,0,1]; //win Prize have index: $i
                                }
                            } 
                            if(!$checkWinPrizeforNoBlock) $winPrizes[$noPeriod][$noBlock][]=null;
                        }
                        else $winPrizes[$noPeriod][$noBlock][]=null;
                    }                     
                }
                else $winPrizes[$noPeriod][]=null;
            }
            $details->winPrizes=$winPrizes;  
            Vietlott::updateWinPrizeForOrder($orderDetail,$details,$checkWinPrize); 
        } 
    }

    // getPrize5V6For3D
    public function getPrize5V6For3D($orderDetail,$numTicket1,$numTicket2,$tempNumbers,$tempValPrize,$prizesName){
        $winPrizes=[]; 

        if(ArrayHelper::in2DArray($numTicket1,$tempNumbers) || ArrayHelper::in2DArray($numTicket2,$tempNumbers) ){ 
            // handle numTicket1
            $countNumTicket1=ArrayHelper::countIn2DArray($numTicket1,$tempNumbers); 
        
            if($countNumTicket1>0){
                $tempTempValPrize=$tempValPrize*$countNumTicket1;
                $tempPrizesName=$prizesName. ' bộ 3 số thứ 1'.($countNumTicket1>1?' (x'.$countNumTicket1.')':'').': ';

                $winPrizes[]=[$tempPrizesName,$tempTempValPrize,$orderDetail->category,0,1]; //win Prize have index: 6    
            } 

            // handle numTicket2
            if($numTicket1==$numTicket2){
                $tempTempValPrize=$tempValPrize*$countNumTicket1;
                $tempPrizesName=$prizesName. ' bộ 3 số thứ 2'.($countNumTicket1>1?' (x'.$countNumTicket1.')':'').': ';
                $winPrizes[]=[$tempPrizesName,$tempTempValPrize,$orderDetail->category,0,1]; //win Prize have index: 6 
            }else{
                $countNumTicket2=ArrayHelper::countIn2DArray($numTicket2,$tempNumbers);
                if($countNumTicket2>0){
                    $tempTempValPrize=$tempValPrize*$countNumTicket2;
                    $tempPrizesName=$prizesName. ' bộ 3 số thứ 2'.($countNumTicket2>1?' (x'.$countNumTicket2.')':'').': ';
                    $winPrizes[]=[$tempPrizesName,$tempTempValPrize,$orderDetail->category,0,1]; //win Prize have index: 6    
                }
            } 
        }
        return $winPrizes;
    }
    // CheckWinPrizeMax3D
    public function CheckWinPrizeMax3DPlus(Prize $prize):void{
        // get prize Info 
        $keyPrize=config('laravelhtmldomparser.categoryType.max3dplus.key').$prize->prize_period;  
        $prizeNumbers=json_decode($prize->prize_number);   
        $temp18Numbers=$prizeNumbers;
        array_shift($temp18Numbers); // remove prizeDB
        $valuePrizes=config('laravelhtmldomparser.categoryType.max3dplus.valuePrizes'); 
        // get orderDetails depend on Prize
        $orderDetails=Orderdetail::where('details_key','like','%'.$keyPrize.'%')->get();
        // handle every orderDetail
        foreach($orderDetails as $orderDetail){ 

            Vietlott::tickDetailsKeyVietlott($orderDetail,$keyPrize);  

            $details=json_decode($orderDetail->details); 
            // check not yet check Winprize  
            $blocksNumbers=$details->blocksNumber; 
            $periodStatus=$details->periodStatus;
            $priceBlocks=$details->priceBlocks;
            $specificPeriods=$details->specificPeriods;
            //dd(gettype($details->winPrizes));
            if(isset($details->winPrizes)) $winPrizes=(array)$details->winPrizes;
            else $winPrizes=[];
            $checkWinPrize=false;  
            // handle ever period
            foreach($specificPeriods as $noPeriod=>$specificPeriod){
                $tempPeriod=explode('|',$specificPeriod);
                $period=trim($tempPeriod[0]);  

                // if samePeriod & periodSuccess && notYetCheckPeriod 
                if($period==$prize->prize_period && $periodStatus[$noPeriod]==config('laravelveso.buyingPeriodsStatus.success.0') ){  
                    foreach($blocksNumbers as $noBlock=>$blocksNumber){
                        if($blocksNumber){// check every block  
                            $numTicket1=$blocksNumber[0];  
                            $numTicket2=$blocksNumber[1];  
                            $checkWinPrizeforNoBlock=false;
                            for($i=0;$i<=3;$i++){ //i=0..3
                                if($this->checkDuplicate2Number($numTicket1,$numTicket2,$prizeNumbers[$i])){ 
                                    $tempValPrize=NumberHelper::toNum($valuePrizes[$i])*$priceBlocks[$noBlock]/10000; 
                                    $checkWinPrize=true;
                                    $checkWinPrizeforNoBlock=true;
                                    $prizesName=config('laravelhtmldomparser.categoryType.max3dplus.prizesName.'.$i);
                                    if($numTicket1==$numTicket2){$tempValPrize=$tempValPrize*2;$prizesName=$prizesName.' x2';}
                                    $winPrizes[$noPeriod][$noBlock][]=[$prizesName,$tempValPrize,$orderDetail->category,0,1]; //win Prize have index: $i
                                }
                            } 
                            //-- check prize 4; Trùng 2 bộ ba số bất kỳ trong 20 bộ ba số All Num
                            $tempPrizes=[]; 
                            foreach($prizeNumbers as $arr) foreach($arr as $val) $tempPrizes[]=$val; 
                            if($this->checkDuplicate2Number($numTicket1,$numTicket2,$tempPrizes)){
                                $tempValPrize=NumberHelper::toNum($valuePrizes[4])*$priceBlocks[$noBlock]/10000;   
                                $checkWinPrize=true;
                                $checkWinPrizeforNoBlock=true;
                                $prizesName=config('laravelhtmldomparser.categoryType.max3dplus.prizesName.4');
                                if($numTicket1==$numTicket2){$tempValPrize=$tempValPrize*2;$prizesName=$prizesName.' x2';}
                                $winPrizes[$noPeriod][$noBlock][]=[$prizesName,$tempValPrize,$orderDetail->category,0,1]; //win Prize have index: 4
                            }
                            //-- check prize 5; Trùng 1 bộ ba số bất kỳ trong 2 bộ ba số giai DB
                            $tempValPrize=NumberHelper::toNum($valuePrizes[5])*$priceBlocks[$noBlock]/10000; 
                            $prizesName=config('laravelhtmldomparser.categoryType.max3dplus.prizesName.5');
                            $tempPrize5=$this->getPrize5V6For3D($orderDetail,$numTicket1,$numTicket2,[$prizeNumbers[0]],$tempValPrize,$prizesName);
                            foreach($tempPrize5 as $valTempPrize5){
                                $winPrizes[$noPeriod][$noBlock][]=$valTempPrize5;
                                $checkWinPrize=true;
                                $checkWinPrizeforNoBlock=true;
                            } 
                            //-- check prize 6; Trùng 1 bộ ba số bất kỳ trong 18 bộ ba số
                            $tempValPrize=NumberHelper::toNum($valuePrizes[6])*$priceBlocks[$noBlock]/10000; 
                            $prizesName=config('laravelhtmldomparser.categoryType.max3dplus.prizesName.6');
                            $tempPrize6=$this->getPrize5V6For3D($orderDetail,$numTicket1,$numTicket2,$temp18Numbers,$tempValPrize,$prizesName);
                            foreach($tempPrize6 as $valTempPrize6){
                                $winPrizes[$noPeriod][$noBlock][]=$valTempPrize6;
                                $checkWinPrize=true;
                                $checkWinPrizeforNoBlock=true;
                            }

                            if(!$checkWinPrizeforNoBlock)$winPrizes[$noPeriod][$noBlock][]=null;
                        }
                        else $winPrizes[$noPeriod][$noBlock][]=null;
                    }                    
                }
                else $winPrizes[$noPeriod][]=null;
                
            }
            $details->winPrizes=$winPrizes;  
            Vietlott::updateWinPrizeForOrder($orderDetail,$details,$checkWinPrize); 
        } 
    }

    // checkDuplicate2Number
    public function checkDuplicate2Number($numTicket1,$numTicket2,$tempPrizes){ 
        $checkNumTicket1=false;
        $checkNumTicket2=false;

        if(in_array($numTicket1,$tempPrizes)){
            $checkNumTicket1=true;
            $key = array_search($numTicket1, $tempPrizes);
            unset($tempPrizes[$key]);
        } 
        if(in_array($numTicket2,$tempPrizes)) $checkNumTicket2=true;  

        return ($checkNumTicket1 && $checkNumTicket2);
    }
    // CheckWinPrizeMax3DPro
    public function CheckWinPrizeMax3DPro(Prize $prize):void{
        Log::debug('CheckWinPrizeMax3DPro');
        // get prize Info 
        $keyPrize=config('laravelhtmldomparser.categoryType.max3dpro.key').$prize->prize_period;  
        $prizeNumbers=json_decode($prize->prize_number);  
        $temp18Numbers=$prizeNumbers;
        array_shift($temp18Numbers);
        $valuePrizes=config('laravelhtmldomparser.categoryType.max3dpro.valuePrizes'); 
        // get orderDetails depend on Prize
        $orderDetails=Orderdetail::where('details_key','like','%'.$keyPrize.'%')->get();
        // handle every orderDetail
        foreach($orderDetails as $orderDetail){ 
            Vietlott::tickDetailsKeyVietlott($orderDetail,$keyPrize);  
            $details=json_decode($orderDetail->details); 
            // check not yet check Winprize  
            $blocksNumbers=$details->blocksNumber; 
            $periodStatus=$details->periodStatus;
            $priceBlocks=$details->priceBlocks;
            $specificPeriods=$details->specificPeriods;
            //dd(gettype($details->winPrizes));
            if(isset($details->winPrizes)) $winPrizes=(array)$details->winPrizes;
            else $winPrizes=[];
            $checkWinPrize=false;  
            // handle ever period
            foreach($specificPeriods as $noPeriod=>$specificPeriod){
                $tempPeriod=explode('|',$specificPeriod);
                $period=trim($tempPeriod[0]);  

                // if samePeriod & periodSuccess && notYetCheckPeriod 
                if($period==$prize->prize_period && $periodStatus[$noPeriod]==config('laravelveso.buyingPeriodsStatus.success.0') ){  
                    foreach($blocksNumbers as $noBlock=>$blocksNumber){
                        if($blocksNumber){// check every block    
                            $numTicket1=$blocksNumber[0];  
                            $numTicket2=$blocksNumber[1];  
                            $checkWinPrizeforNoBlock=false;
                            //-- check prize ĐB; 
                            if($numTicket1==$prizeNumbers[0][0] && $numTicket2==$prizeNumbers[0][1]){ 
                                $checkWinPrize=true;  
                                $checkWinPrizeforNoBlock=true;
                                $prizesName=config('laravelhtmldomparser.categoryType.max3dpro.prizesName.0');
                                $winPrizes[$noPeriod][$noBlock][]=[$prizesName,$valuePrizes[0],$prize->category,0,1]; //win Prize have index: $i
                            }
                            //-- check prize ĐB Phụ; 
                            if($numTicket1==$prizeNumbers[0][1] && $numTicket2==$prizeNumbers[0][0]){
                                $checkWinPrize=true;  
                                $checkWinPrizeforNoBlock=true;
                                $prizesName=config('laravelhtmldomparser.categoryType.max3dpro.prizesName.7');
                                $winPrizes[$noPeriod][$noBlock][]=[$prizesName,$valuePrizes[7],$prize->category,0,1]; //win Prize have index: $i
                            }
                            //-- check prize i=1..3  
                            for($i=1;$i<=3;$i++){  
                                if($this->checkDuplicate2Number($numTicket1,$numTicket2,$prizeNumbers[$i])){ 
                                    $tempValPrize=NumberHelper::toNum($valuePrizes[$i])*$priceBlocks[$noBlock]/10000; 
                                    $checkWinPrize=true; 
                                    $checkWinPrizeforNoBlock=true;
                                    $prizesName=config('laravelhtmldomparser.categoryType.max3dpro.prizesName.'.$i);
                                    if($numTicket1==$numTicket2){$tempValPrize=$tempValPrize*2;$prizesName=$prizesName.' (x2)';}
                                    $winPrizes[$noPeriod][$noBlock][]=[$prizesName,$tempValPrize,$prize->category,0,1]; //win Prize have index: $i
                                    
                                }
                            } 
                            //-- check prize 4; Trùng 2 bộ ba số bất kỳ trong 20 bộ ba số All Num 
                            $tempPrizes=[]; 
                            foreach($prizeNumbers as $arr) foreach($arr as $val) $tempPrizes[]=$val; 
                            
                            if($this->checkDuplicate2Number($numTicket1,$numTicket2,$tempPrizes)){ 
                                $tempValPrize=NumberHelper::toNum($valuePrizes[4])*$priceBlocks[$noBlock]/10000; 
                                $checkWinPrize=true; 
                                $checkWinPrizeforNoBlock=true;
                                $prizesName=config('laravelhtmldomparser.categoryType.max3dpro.prizesName.4');
                                if($numTicket1==$numTicket2){$tempValPrize=$tempValPrize*2;$prizesName=$prizesName.' (x2)';}
                                $winPrizes[$noPeriod][$noBlock][]=[$prizesName,$tempValPrize,$prize->category,0,1]; //win Prize have index: 4
                                
                            }
                            //-- check prize 5; Trùng 1 bộ ba số bất kỳ trong 2 bộ ba số giai DB 
                            $tempValPrize=NumberHelper::toNum($valuePrizes[5])*$priceBlocks[$noBlock]/10000; 
                            $prizesName=config('laravelhtmldomparser.categoryType.max3dpro.prizesName.5');
                            $tempPrize5=$this->getPrize5V6For3D($orderDetail,$numTicket1,$numTicket2,[$prizeNumbers[0]],$tempValPrize,$prizesName);
                            foreach($tempPrize5 as $valTempPrize5){
                                $winPrizes[$noPeriod][$noBlock][]=$valTempPrize5;
                                $checkWinPrize=true;
                                $checkWinPrizeforNoBlock=true;
                            }
 
                            //-- check prize 6; Trùng 1 bộ ba số bất kỳ trong 18 bộ ba số
                            $tempValPrize=NumberHelper::toNum($valuePrizes[6])*$priceBlocks[$noBlock]/10000; 
                            $prizesName=config('laravelhtmldomparser.categoryType.max3dpro.prizesName.6');
                            $tempPrize6=$this->getPrize5V6For3D($orderDetail,$numTicket1,$numTicket2,$temp18Numbers,$tempValPrize,$prizesName);
                            foreach($tempPrize6 as $valTempPrize6){
                                $winPrizes[$noPeriod][$noBlock][]=$valTempPrize6;
                                $checkWinPrize=true;
                                $checkWinPrizeforNoBlock=true;
                            }
                            if(!$checkWinPrizeforNoBlock) $winPrizes[$noPeriod][$noBlock][]=null;
                        }
                        else $winPrizes[$noPeriod][$noBlock][]=null;
                    }                    
                }
                else $winPrizes[$noPeriod][]=null;
            }  
            $details->winPrizes=$winPrizes;  
            Vietlott::updateWinPrizeForOrder($orderDetail,$details,$checkWinPrize); 
        } 
    }

    // CheckWinPrizeKeno
    public function CheckWinPrizeKeno(Prize $prize):void{
        // get prize Info 
        $keyPrize=config('laravelhtmldomparser.categoryType.keno.key').$prize->prize_period;  
        $prizeNumbers=json_decode($prize->prize_number);    
        // caculate result
        $even=0;$big=0;
        foreach($prizeNumbers as $num) {
            if($num % 2==0) $even++; 
            if($num > 40) $big++;
        }
        // valuePrizes
        $valuePrizes=config('laravelhtmldomparser.categoryType.keno.valuePrizes'); 
        // get orderDetails depend on Prize
        $orderDetails=Orderdetail::where('details_key','like','%'.$keyPrize.'%')->get();
        // handle every orderDetail
        foreach($orderDetails as $orderDetail)
        //if($orderDetail->id==215)
        { 
            Vietlott::tickDetailsKeyVietlott($orderDetail,$keyPrize);  

            $details=json_decode($orderDetail->details); 
            // check not yet check Winprize  
            $blocksNumbers=$details->blocksNumber; 
            $periodStatus=$details->periodStatus;
            $priceBlocks=$details->priceBlocks;
            $specificPeriods=$details->specificPeriods;
            $methodSelected=$details->methodSelected;
            //dd(gettype($details->winPrizes));
            if(isset($details->winPrizes)) $winPrizes=(array)$details->winPrizes;
            else $winPrizes=[];
            $checkWinPrize=false;  
            // handle ever period 
            foreach($specificPeriods as $noPeriod=>$specificPeriod){
                $tempPeriod=explode('|',$specificPeriod);
                $period=trim($tempPeriod[0]);  
                // if samePeriod & periodSuccess && notYetCheckPeriod  
                // with Keno Only have $periodStatus[0]
                if($period==$prize->prize_period && $periodStatus[$noPeriod]==config('laravelveso.buyingPeriodsStatus.success.0')){   
                    foreach($blocksNumbers as $noBlock=>$blocksNumber){ 
                        if($blocksNumber){// check every block    
                            $checkWinPrizeforNoBlock=false;
                            // level: 1..10 (0..9)
                            if($methodSelected<10){
                                $duplicateNum=0;
                                foreach($blocksNumber as $num)
                                if(in_array($num,$prizeNumbers)) $duplicateNum++;
                                //caculate totalWinPrize
                                $tempValPrice=$valuePrizes[$methodSelected][$duplicateNum]*$priceBlocks[$noBlock]/10000;
                                $checkWinPrize=true;
                                $checkWinPrizeforNoBlock=true;
                                $winPrizes[$noPeriod][$noBlock][]=[$duplicateNum,$tempValPrice,$prize->category,0,1];
                                //dump($winPrizes);
                            }
                            // even-odd 
                            if($methodSelected==10){  
                                $prizeResult=Vietlott::getPrizeKenoEvenOdd($blocksNumber,$even);  
                                $tempValPrice=$prizeResult[1]*$priceBlocks[$noBlock]/10000;
                                $checkWinPrize=true;
                                $checkWinPrizeforNoBlock=true;
                                $winPrizes[$noPeriod][$noBlock][]=[$prizeResult[0],$tempValPrice,$prize->category,0,1];  
                            }
                            // big-small
                            if($methodSelected==11){
                                $prizeResult=Vietlott::getPrizeKenoBigSmall($blocksNumber,$big); 
                                $tempValPrice=$prizeResult[1]*$priceBlocks[$noBlock]/10000;
                                $checkWinPrize=true; 
                                $checkWinPrizeforNoBlock=true;
                                $winPrizes[$noPeriod][$noBlock][]=[$prizeResult[0],$tempValPrice,$prize->category,0,1];
                            }
                            if(!$checkWinPrizeforNoBlock)$winPrizes[$noPeriod][$noBlock][]=null;
                        }
                        else $winPrizes[$noPeriod][$noBlock][]=null;
                    }                    
                }
                else $winPrizes[$noPeriod][]=null;
            }    
            //dd($winPrizes);
            $details->winPrizes=$winPrizes;  
            Vietlott::updateWinPrizeForOrder($orderDetail,$details,$checkWinPrize); 
        } 
    }

    // getUpdateTorefundTickets
    public function getUpdateTorefundTickets($agencyId,$customer,$orderDetail,$details,$typeUpdate){ 
        // getRefundTicketForCustomer
        $tempRefundTicket=Vietlott::getRefundTicketForCustomer($customer,$agencyId);
        $refundTickets=$tempRefundTicket[0];
        $agencyIndex=$tempRefundTicket[1];

        if($details->game_type==config('laravelhtmldomparser.categoryType.traditionallottery.gameType.vethuong.key')){
            $quantityReturn=($orderDetail->quantity-$orderDetail->quantity_refund)*$typeUpdate;
            $refundTickets[$agencyIndex][1]+=$quantityReturn; 
        }
        else $refundTickets[$agencyIndex][2]+=(1*$typeUpdate); 
        $customer->update(['refund_tickets'=>json_encode($refundTickets)]);
        //Log::debug($refundTickets);
    }

    // caculate tax
    public function getTax($winPrizeValue,$qtyTicketWin=1){
        
        $value1Ticket=$winPrizeValue/$qtyTicketWin;

        if($value1Ticket>=config('laravelveso.configPayment.limitPointHaveTax'))
            $tax1Ticket=($value1Ticket-config('laravelveso.configPayment.limitPointHaveTax'))*config('laravelveso.configPayment.personalIncomeTax');
        else $tax1Ticket=0;
        
        $tax=$tax1Ticket*$qtyTicketWin; 

        return $tax;
    }

    // caculateMoneyTranferWinPrize = -tax - helpGetWinPrize
    public function caculateMoneyTranferWinPrize($winPrizeValue,$qtyTicketWin=1){
        //value1Ticket
        $value1Ticket=$winPrizeValue/$qtyTicketWin;
        // comisson help get help reward  
        if(($value1Ticket)>=config('laravelveso.configPayment.limitGetComissionForAgency'))
            $commissionForHelpGetRewarded=$winPrizeValue*SettingHelper::getKey('commission_for_help_get_rewarded')/100;
        else $commissionForHelpGetRewarded=0;

        // tax
        $tax=$this->getTax($winPrizeValue,$qtyTicketWin);

        $moneyNeedAddCustomer=$winPrizeValue-($commissionForHelpGetRewarded+$tax);

        // Log::debug('caculateMoneyTranferWinPrize: '.$winPrizeValue.'-'.$moneyNeedAddCustomer.'-'.$commissionForHelpGetRewarded.'-'.$tax);

        return $moneyNeedAddCustomer;
    }

    //=============
    public function updateWinPrizeTraditional($request, $orderDetail){
        $details=json_decode($orderDetail->details);   
        // get customer & agency
        $order=Order::find($orderDetail->order_id); 
        $orderTitle='(HĐ: <a href="'.route('customer.order.show',['order'=>$order]).'">#'. $order->id.'</a>)';
        $details=json_decode($orderDetail->details);

        $customer=User::find($order->userId);
        $agency=User::find($details->agency_id);


        $checkLockPoint=LockPoint::checkLockPointUsers([$customer,$agency]);
        $customer=User::find($order->userId);
        $agency=User::find($details->agency_id);
        Log::debug($customer->point.'-'.$customer->point_info);
        Log::debug($agency->point.'-'.$agency->point_info);
        
        if($checkLockPoint){
            return ['idMsg'=>$request->idMsg,'winPrizeStatus'=>$request->winPrizeStatus,'error'=>'Server đang bận hãy thử lại sau 1 phút'];
        }  

        // caculate totalPoint
        $totalPointOfficial=0;//prize of Official
        $totalPointAgency=0;//prize of Agency
        $noWinLast2NumPrizeDB=-1; 
        $checkPrizeNeedContact=false;
        $countPrizeOfficial=0;
        $moneyNeedAddCustomer=0;
        $quantityBuy=0; 

        // caculate pointtranfer
        foreach($details->winPrizes as $noWin=>$winPrize)
        if($winPrize){ 

            Log::debug('$winPrize',[$winPrize]);

            if($winPrize[1]==config('laravelhtmldomparser.extraPrize.last2NumPrizeDB.key'))$noWinLast2NumPrizeDB=$noWin;           
            else 
                if($winPrize[1]==config('laravelhtmldomparser.extraPrize.last3NumPrizeDB.key')||
                   $winPrize[1]==config('laravelhtmldomparser.extraPrize.last4NumPrizeDB.key'))  $totalPointAgency+=$winPrize[1];  
                else{
                    $countPrizeOfficial++;
                    Log::debug('winPrize: ',$winPrize);
                    $totalPointOfficial+=$winPrize[1];
                    $quantityBuy=$winPrize[4];
                }
        }  

        $totalPoint=$totalPointAgency+$totalPointOfficial;  

        // capnguyen && countPrizeOfficial>1 -> contact
        if($details->game_type==config('laravelhtmldomparser.categoryType.traditionallottery.gameType.capnguyen.key') &&            $countPrizeOfficial>1) $checkPrizeNeedContact=true;
        else{
            if($quantityBuy>0)
            $moneyNeedAddCustomer=$totalPointAgency + $this->caculateMoneyTranferWinPrize($totalPointOfficial,$quantityBuy);
            else $moneyNeedAddCustomer=0;
        } 
 
        // if has in DB -> get, serve for cancel == add
        $winPrizePeriod=WinPrize::where('order_detail_id',$request->orderDetailId)->first();
        if($request->winPrizeStatus==config('laravelveso.winPrizeStatus.cancel.key') &&
        $winPrizePeriod->moneyNeedAddCustomer) $moneyNeedAddCustomer=$winPrizePeriod->moneyNeedAddCustomer;

        // for show result in frontend
        $pointTranfer=0;
        Log::debug($moneyNeedAddCustomer);

        // handle success
        if($request->winPrizeStatus==config('laravelveso.winPrizeStatus.success.key')
        && $winPrizePeriod->status!=config('laravelveso.winPrizeStatus.success.key') 
        && $winPrizePeriod->status!=config('laravelveso.winPrizeStatus.contact.key') ){// submit success
            if($moneyNeedAddCustomer<config('laravelveso.configPayment.pointLimitTranfer')
            && !$checkPrizeNeedContact){//tranferPoint
                if($moneyNeedAddCustomer>$agency->point){
                    LockPoint::unLockPointUsers([$customer,$agency]);
                    return ['idMsg'=>$request->idMsg,'winPrizeStatus'=>$request->winPrizeStatus,'error'=>'Đại lý không đủ điểm để trả thưởng!'];
                }
                else{
                    $newPoint=$customer->point+$moneyNeedAddCustomer;  
                    $pointTranfer=$moneyNeedAddCustomer;
                    $log=config('laravelauth.userLogAction.receivedWinPrize').' '.Vietlott::getStringOrderDetail($orderDetail).'  ('.number_format($moneyNeedAddCustomer).'Đ). Số tiền hiện tại trong Ví:  '.number_format($newPoint).'Đ '.$orderTitle;
                    Vietlott::updatePointForCustomer($customer,$newPoint,$log,true);
                    Vietlott::updatePointInfoForCustomer($customer,$moneyNeedAddCustomer,config('laravelveso.pointInfo.pointWinPrize.key')); 
                    // for agency, agency implement this action
                    if($agency->id==$customer->id) $agency=User::find($details->agency_id);
                    // for agency
                    $newPoint=$agency->point-$moneyNeedAddCustomer;  
                    $log=config('laravelauth.userLogAction.getPointToReward').' '.Vietlott::getStringOrderDetail($orderDetail).' ('.number_format(-$moneyNeedAddCustomer).'Đ)'.'. Số tiền hiện tại trong Ví:  '.number_format($newPoint).'Đ '.$orderTitle;
                    Vietlott::updatePointForCustomer($agency,$newPoint,$log);
                    Vietlott::updatePointInfoForCustomer($agency,$moneyNeedAddCustomer,config('laravelveso.pointInfo.pointPaidPrize.key')); 
                    $winPrizePeriod->update(['status'=>$request->winPrizeStatus,'moneyNeedAddCustomer'=>$moneyNeedAddCustomer]);//success
                    TraditionalTicket::updateWinPrizeStatus($orderDetail,$request->winPrizeStatus,$moneyNeedAddCustomer,$totalPoint);
                }
                
            }else{//onlySubmit
                $log=config('laravelauth.userLogAction.agencySubmiWinPrize').' '.Vietlott::getStringOrderDetail($orderDetail).' ('.config('laravelveso.configPayment.explainPointLimitTranfer').') '.$orderTitle; 
                Notification::send($customer, new WinPrizeNotifications($customer,$message=['title'=>$log])); 
                $winPrizePeriod->update(['status'=>config('laravelveso.winPrizeStatus.contact.key'),'moneyNeedAddCustomer'=>0]);// success and contact
                TraditionalTicket::updateWinPrizeStatus($orderDetail,config('laravelveso.winPrizeStatus.contact.key'),null,$totalPoint);
            }
            // update getUpdateTorefundTickets
            if($noWinLast2NumPrizeDB>=0) 
            $this->getUpdateTorefundTickets($agency->id,$customer,$orderDetail,$details,1);   
        }

        // handle cancel; ****if befor success => return else not retrurn
        if($request->winPrizeStatus==config('laravelveso.winPrizeStatus.cancel.key')
        && $winPrizePeriod->status!=$request->winPrizeStatus){// submit success
            if($moneyNeedAddCustomer<config('laravelveso.configPayment.pointLimitTranfer')
            && !$checkPrizeNeedContact){//tranferPoint
                if($moneyNeedAddCustomer>$customer->point){
                    LockPoint::unLockPointUsers([$customer,$agency]);
                    return ['idMsg'=>$request->idMsg,'winPrizeStatus'=>$request->winPrizeStatus,'error'=>'Khách không đủ điểm để đại lý hủy trả thưởng!'];
                }
                else // tranfer point if before status is success
                    if($winPrizePeriod->status==config('laravelveso.winPrizeStatus.success.key'))
                    { 
                        $newPoint=$customer->point-$moneyNeedAddCustomer;  
                        $pointTranfer=$moneyNeedAddCustomer;
                        $log=config('laravelauth.userLogAction.cancelReceivedWinPrize').' '.Vietlott::getStringOrderDetail($orderDetail).' ('.number_format(-$moneyNeedAddCustomer).'Đ)'.'. Số tiền hiện tại trong Ví:  '.number_format($newPoint).'Đ '.$orderTitle; ;
                        Vietlott::updatePointForCustomer($customer,$newPoint,$log,true);
                        Vietlott::updatePointInfoForCustomer($customer,-$moneyNeedAddCustomer,config('laravelveso.pointInfo.pointWinPrize.key')); 
                        // for agency, agency implement this action
                        if($agency->id==$customer->id) $agency=User::find($details->agency_id);
                        $newPoint=$agency->point+$moneyNeedAddCustomer;  
                        $log=config('laravelauth.userLogAction.cancelGetPointToReward').' '.Vietlott::getStringOrderDetail($orderDetail).' ('.number_format($moneyNeedAddCustomer).'Đ)'.'. Số tiền hiện tại trong Ví:  '.number_format($newPoint).'Đ '.$orderTitle;
                        Vietlott::updatePointForCustomer($agency,$newPoint,$log);
                        Vietlott::updatePointInfoForCustomer($agency,-$moneyNeedAddCustomer,config('laravelveso.pointInfo.pointPaidPrize.key')); 
                    }
            }else{//only Submit
                $log=config('laravelauth.userLogAction.agencyCancelSubmiWinPrize').' '.Vietlott::getStringOrderDetail($orderDetail).' '.$orderTitle; 
                Notification ::send($customer, new WinPrizeNotifications($customer,$message=['title'=>$log])); 
            }
            $winPrizePeriod->update(['status'=>$request->winPrizeStatus,'moneyNeedAddCustomer'=>0]);
            TraditionalTicket::updateWinPrizeStatus($orderDetail,$request->winPrizeStatus,null,$totalPoint);
            // update getUpdateTorefundTickets
            if($noWinLast2NumPrizeDB>=0) 
            $this->getUpdateTorefundTickets($agency->id,$customer,$orderDetail,$details,-1);   
        }

        LockPoint::unLockPointUsers([$customer,$agency]);
        return ['idMsg'=>$request->idMsg,'winPrizeStatus'=>$request->winPrizeStatus,'message'=>'success','pointTranfer'=>$pointTranfer]; 
    }


    //updateWinPrizeVietlott
    public function updateWinPrizeVietlott($request){
        // get info orderDetail & winPrize
        $winPrizePeriod=WinPrize::where('order_detail_id',$request->orderDetailId)->where('noPeriod',$request->noPeriod)->first();
        $orderDetail=Orderdetail::find($request->orderDetailId);
        $details=json_decode($orderDetail->details);
        $order=Order::find($orderDetail->order_id);
        $orderTitle='(HĐ: <a href="'.route('customer.order.show',['order'=>$order]).'">#'. $order->id.'</a>)';
        $customer=User::find($order->userId); 

        $checkLockPoint=LockPoint::checkLockPointUsers([$customer]);
        $customer=User::find($order->userId);
        
        if($checkLockPoint){
            Log::debug('updateWinPrizeVietlott: Server đang bận hãy thử lại sau 1 phút');
            return ['idMsg'=>$request->idMsg,'winPrizeStatus'=>$request->winPrizeStatus,'error'=>'Server đang bận hãy thử lại sau 1 phút']; 
        }
         
        //------
        $noPeriod=$request->noPeriod;  
        $winPrizes=(array)$details->winPrizes[$noPeriod];
        // caculate totalPoint
        $totalPoint=0;
        $checkPrizeNeedContact=false;
        foreach($details->blocksNumber as $noBlock=>$block)
        if($winPrizes[$noBlock])
        foreach($winPrizes[$noBlock] as $noWin=>$winPrize)
        if($winPrize){
            if(NumberHelper::isNumber($winPrize[1])) $totalPoint+=$winPrize[1];   
            else $checkPrizeNeedContact=true;
        }  
        // substract Tax
        $moneyNeedAddCustomer=$this->caculateMoneyTranferWinPrize($totalPoint);

        // if has in DB -> get , serve for cancel == add
        if($winPrizePeriod->moneyNeedAddCustomer) $moneyNeedAddCustomer=$winPrizePeriod->moneyNeedAddCustomer;
        // for show result in frontend
        $pointTranfer=0;
        // handle success
        if($request->winPrizeStatus==config('laravelveso.winPrizeStatus.success.key')
        && $winPrizePeriod->status!=config('laravelveso.winPrizeStatus.success.key') 
        && $winPrizePeriod->status!=config('laravelveso.winPrizeStatus.contact.key') ){// submit success
            if($moneyNeedAddCustomer<config('laravelveso.configPayment.pointLimitTranfer') && !$checkPrizeNeedContact){//tranferPoint
                $newPoint=$customer->point+$moneyNeedAddCustomer;  
                $pointTranfer=$moneyNeedAddCustomer;
                $log=config('laravelauth.userLogAction.receivedWinPrize').' '.Vietlott::getStringOrderDetail($orderDetail).' ('.number_format($moneyNeedAddCustomer).')'.'. Số tiền hiện tại trong Ví:  '.number_format($newPoint).'Đ '.$orderTitle;
                Vietlott::updatePointForCustomer($customer,$newPoint,$log,true);
                Vietlott::updatePointInfoForCustomer($customer,$moneyNeedAddCustomer,config('laravelveso.pointInfo.pointWinPrize.key')); 
                $winPrizePeriod->update(['status'=>$request->winPrizeStatus,'moneyNeedAddCustomer'=>$moneyNeedAddCustomer]);//success
                Vietlott::updateWinPrizePeriodStatus($orderDetail,$request->noPeriod,$request->winPrizeStatus,$moneyNeedAddCustomer,$totalPoint);
            }else{//onlySubmit
                $log=config('laravelauth.userLogAction.agencySubmiWinPrize').' '.Vietlott::getStringOrderDetail($orderDetail).' ('.config('laravelveso.configPayment.explainPointLimitTranfer').') '.$orderTitle;
                Notification ::send($customer, new WinPrizeNotifications($customer,$message=['title'=>$log])); 
                $winPrizePeriod->update(['status'=>config('laravelveso.winPrizeStatus.contact.key'),'moneyNeedAddCustomer'=>0]);// success and contact
                Vietlott::updateWinPrizePeriodStatus($orderDetail,$request->noPeriod,config('laravelveso.winPrizeStatus.contact.key'),null,$totalPoint);
            }
        }
        // handle cancel
        if($request->winPrizeStatus==config('laravelveso.winPrizeStatus.cancel.key')
        && $winPrizePeriod->status!=$request->winPrizeStatus){// submit success
            if($moneyNeedAddCustomer<config('laravelveso.configPayment.pointLimitTranfer') && !$checkPrizeNeedContact){//tranferPoint
                if($moneyNeedAddCustomer>$customer->point){
                    LockPoint::unLockPointUsers([$customer]);
                    return ['idMsg'=>$request->idMsg,'winPrizeStatus'=>$request->winPrizeStatus,'error'=>'Khách không đủ điểm để đại lý hủy trả thưởng!'];
                }
                else // tranfer point if before status is success
                    if($winPrizePeriod->status==config('laravelveso.winPrizeStatus.success.key'))
                    {
                        $newPoint=$customer->point-$moneyNeedAddCustomer;  
                        $pointTranfer=$moneyNeedAddCustomer;
                        $log=config('laravelauth.userLogAction.cancelReceivedWinPrize').' '.Vietlott::getStringOrderDetail($orderDetail).' ('.number_format($moneyNeedAddCustomer).'). Số tiền hiện tại trong Ví:  '.number_format($newPoint).'Đ '.$orderTitle;
                        Vietlott::updatePointForCustomer($customer,$newPoint,$log,true);
                        Vietlott::updatePointInfoForCustomer($customer,-$moneyNeedAddCustomer,config('laravelveso.pointInfo.pointWinPrize.key')); 
                    }
            }else{//onlySubmit
                $log=config('laravelauth.userLogAction.agencyCancelSubmiWinPrize').' '.Vietlott::getStringOrderDetail($orderDetail).' '.$orderTitle; 
                Notification ::send($customer, new WinPrizeNotifications($customer,$message=['title'=>$log])); 
            }
 
            $winPrizePeriod->update(['status'=>$request->winPrizeStatus,'moneyNeedAddCustomer'=>0]);

            Vietlott::updateWinPrizePeriodStatus($orderDetail,$request->noPeriod,$request->winPrizeStatus,null,$totalPoint); 
        }

        

        LockPoint::unLockPointUsers([$customer]);
        return ['idMsg'=>$request->idMsg,'winPrizeStatus'=>$request->winPrizeStatus,'message'=>'success','pointTranfer'=>$pointTranfer]; 

    }
}

?>
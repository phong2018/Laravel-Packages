<?php
use Phonglg\LaravelVeso\Helpers\Vietlott;
if(!isset($showFunction)) $showFunction=true; 
?>
<tr class="">

    <?php
        $linkDetailResult='';
        if(isset($specificPeriods) && isset($specificPeriods[$noPeriod])) $tempArr=explode("|",$specificPeriods[$noPeriod]);
        else $tempArr=['',''];
        $tempPeriod=trim(str_replace("#","",$tempArr[0]));
        
        switch($detail['category']){
            case config('laravelhtmldomparser.categoryType.mega645.key'):
                $linkDetailResult=route('prizes.showXosoMega645',['prize_period'=>$tempPeriod]);break;
            case config('laravelhtmldomparser.categoryType.power655.key'):
                $linkDetailResult=route('prizes.showXosoPower655',['prize_period'=>$tempPeriod]);break;
            case config('laravelhtmldomparser.categoryType.max3d.key'):
                $linkDetailResult=route('prizes.showXosoMax3D',['prize_period'=>$tempPeriod]);break;
            case config('laravelhtmldomparser.categoryType.max3dplus.key'):
                $linkDetailResult=route('prizes.showXosoMax3D',['prize_period'=>$tempPeriod]);break;
            case config('laravelhtmldomparser.categoryType.max3dpro.key'):
                $linkDetailResult=route('prizes.showXosoMax3DPro',['prize_period'=>$tempPeriod]);break;
            case config('laravelhtmldomparser.categoryType.keno.key'):
                $linkDetailResult=route('prizes.showXosoKeno',['prize_period'=>$tempPeriod]);break;
        }
    ?>  

    @if($period)
    <td>
        <span>
            Kỳ: 
            <span class='font-bold'>
                @if(isset($specificPeriods) && isset($specificPeriods[$noPeriod]))
                <a target='blank' class='text-blue-700' href='{{$linkDetailResult}}'> {{$specificPeriods[$noPeriod]}} </a> (#{{$period}})
                @else
                    {{"#".$period}}
                @endif
            </span>
            <p> 
            Tình Trạng vé: <span class='font-bold'>{!! Vietlott::showperiodStatus($periodStatus[$noPeriod]) !!} </span>
            </p>
        </span>

        <?php
        //dump($detail['winPrizePeriodStatus'][$noPeriod])
        ?>
        @if(isset($detail['winPrizePeriodStatus']) && isset($detail['winPrizePeriodStatus'][$noPeriod][0]))
            <div class='overflow-hidden w-full'>
                Trả thưởng:
                <span class='border rounded px-2 text-white winPrizeStatus-{{$detail['winPrizePeriodStatus'][$noPeriod][0]}}'>
                {{config('laravelveso.winPrizeStatus.'.$detail['winPrizePeriodStatus'][$noPeriod][0].'.label')}} 
                </span>     
                @if(isset($detail['winPrizePeriodStatus'][$noPeriod][1]) && isset($detail['winPrizePeriodStatus'][$noPeriod][2]))
                    &nbsp <span class='font-bold mt-1 inline-block'> 
                        {{number_format($detail['winPrizePeriodStatus'][$noPeriod][1])}}Đ/{{number_format($detail['winPrizePeriodStatus'][$noPeriod][2])}}Đ  
                    </span> 
                @endif
            </div>
        @endif 
    </td> 
    
    <td class='align-top  '>
        @can('admin-updateOrderDetail')

            @if($detail['category']!=config('laravelhtmldomparser.categoryType.keno.key')
            || $noPeriod==0
            ) 
                <span onClick="confirmFunctionSubmit(updateOrderDetail,['{{$orderDetailId}}#{{$noPeriod}}','canceled'],$message='Xác nhận?')" class='btn btn-danger float-right text-base w-20  p-1

                @if($periodStatus[$noPeriod]==config("laravelveso.buyingPeriodsStatus.canceled.0") ||
                $data["orderStatusValue"]==config("laravelveso.orderStatus.failure.key"))
                    disabled
                @endif  

                '>Hủy Vé</span>  
            @endif
        @endcan
    </td> 
    
@endif
</tr>
@if(isset($detail['winPrizes'][$noPeriod]))
    <?php $winPrize=(array)$detail['winPrizes'][$noPeriod];?>
    <tr>
        <td> 
        @foreach ($detail['blocksNumber'] as $noBlock=>$block)
            @if(isset($winPrize[$noBlock])) 
                @if($detail['category']==config('laravelhtmldomparser.categoryType.keno.key'))   
                    @include('laravelveso::adminOrder.componentOrder.winPrizeForVietlottKeno')  
                @else 
                    @include('laravelveso::adminOrder.componentOrder.winPrizeForVietlott') 
                @endif 
            @endif
        @endforeach   
        </td>
        @if($showFunction)
        <td class='align-top'>
            <!-- update winPrize -->
            @include('laravelveso::adminOrder.componentOrder.updateWinPrizeVietlott') 
        </td>
        @endif
    </tr>
@endif
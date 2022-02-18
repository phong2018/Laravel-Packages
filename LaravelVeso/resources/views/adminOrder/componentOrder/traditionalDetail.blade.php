<?php
use Phonglg\LaravelLayout\Helpers\Date;
use Phonglg\LaravelVeso\Helpers\Vietlott; 
use Phonglg\LaravelVeso\Helpers\ImageHelper; 
use Phonglg\LaravelLayout\Helpers\NumberHelper;
if(!isset($showFunction)) $showFunction=true;
?>

<table class="w-full"> 


<table class="w-full">
    <tr>
        <td class='w-full'>

            <?php
                $linkDetailResult=''; 
                $tempPeriod=Date::dateDMYtoYMD($orderDetail->prize_date); 
                switch($orderDetail->options['ticket_category']){
                    case config('laravelhtmldomparser.categoryType.miennam.key'):
                        $linkDetailResult=route('prizes.showXosoMienNam',['prize_period'=>$tempPeriod]);break;
                    case config('laravelhtmldomparser.categoryType.mientrung.key'):
                        $linkDetailResult=route('prizes.showXosoMienTrung',['prize_period'=>$tempPeriod]);break;
                    case config('laravelhtmldomparser.categoryType.mienbac.key'):
                        $linkDetailResult=route('prizes.showXosoMienBac',['prize_period'=>$tempPeriod]);break; 
                }
            ?> 

        
            <?php $tempName=explode('|',$orderDetail->name)?>

            <table class="w-full">
                <td class='align-top pr-3 w-20'> 
                <img src="{{asset('/storage/photos/1/Provinces/'.$tempName[1].'.png')}}" alt="" class="w-20 "> 
                </td>
                <td>
                    <div class='w-full overflow-hidden'>
                        <p class='pt-1 float-left font-bold inline-block mb-0'>{{ $tempName[0] }}</p>
                        <p class='pt-1 inline-block float-left'>  &nbsp|&nbsp  {{ $data['provinces'][$tempName[1]] }}
                        | {{ config('laravelhtmldomparser.categoryType.traditionallottery.gameType.'.$orderDetail->options['game_type'].'.name') }}
                        | Kỳ: @if(isset($orderDetail->options['period']))  {{$orderDetail->options['period']}}  @endif
                        </p>  
                        <!-- orderDetail status   -->
                    </div> 

                    <p>Ngày sổ: <a target='blank' class='text-blue-700 font-bold' href='{{$linkDetailResult}}'> #{{ $orderDetail->prize_date }}</a></p>  

                    <p>
                        Số lượng: {{ $orderDetail->qty }}
                    
                        @if(isset($orderDetail->options['qtyRefund']) && $orderDetail->options['qtyRefund']>0) [<i class="fas fa-gift text-blue-500" title='Vé tặng'></i> {{$orderDetail->options['qtyRefund']}}] @endif 

                        . Giá vé: {{ number_format($orderDetail->price) }}Đ
                        @if($orderDetail->price==0)
                        (Vé được hoàn)
                        @endif
                    </p>
                    
                    <div class='w-full overflow-hidden'> 

                        @if(isset($orderDetail->options['agency']))
                            <p class='inline-block float-left'>
                            NCC: {{$orderDetail->options['agency']}}
                            </p>
                        @endif 
                    </div> 
                 
                    @if($orderDetail->qty_refund>0)
                        Số vé hủy: <span class='font-bold'>{{$orderDetail->qty_refund}}</span>
                    @else
                        Tình trạng vé: <span class='font-bold'>Thành công</span> 
                    @endif
                   

                    <!-- ------------------ -->
                    @if(isset($orderDetail->options['winPrizeStatus'][0]) && isset($orderDetail->options['winPrizeStatus'][0]))
                    <div class='overflow-hidden w-full'>
                            <p class='pt-1 inline-block float-left'> 
                            Trả thưởng:
                            <span class='border rounded px-2 text-white winPrizeStatus-{{$orderDetail->options['winPrizeStatus'][0]}}'>
                            {{config('laravelveso.winPrizeStatus.'.$orderDetail->options['winPrizeStatus'][0].'.label')}} 
                            </span>   
                            </p>    
                            
                            @if(isset($orderDetail->options['winPrizeStatus'][1]) && isset($orderDetail->options['winPrizeStatus'][2]))
                            &nbsp <span class='font-bold mt-1 inline-block'> 
                                {{number_format($orderDetail->options['winPrizeStatus'][1])}}Đ/{{number_format($orderDetail->options['winPrizeStatus'][2])}}Đ
                            </span>
                            @endif
                    </div>
                    @endif 
                    <!-- ------------------ --> 
                    @include('laravelveso::adminOrder.componentOrder.ajaxUploadFile')  
                    <!-- ================= -->
                    @if(isset($orderDetail->options['winPrizes']))
                    <table class='w-full'>
                        <tr>
                            <td colspan="2"> 
                                @foreach($orderDetail->options['winPrizes'] as $noWin=>$win)
                                @if($win)
                                <div class='pb-1'>
                                <i class="fas fa-angle-right"></i>
                                
                                <span class='text-red-500'>
                                        {{ $win[0] }}
                                        @if( NumberHelper::isNumber( $win[1]) )  
                                            {{number_format($win[1])}}Đ
                                        @else 
                                            @if($win[1]==config('laravelhtmldomparser.extraPrize.last2NumPrizeDB.key'))
                                                được hoàn lại số vé đã mua   
                                            @else
                                                {{$win[1]}}
                                            @endif
                                        @endif
                                    </span>
                    
                                    @if($win[0]!=config('laravelhtmldomparser.extraPrize.last2NumPrizeDB.key'))
                                        @include('laravelveso::adminOrder.componentOrder.checkSubmitWinPrize')
                                    @endif  
                                    
                                </div>
                                @endif
                                @endforeach 
                            </td>
                            @if($showFunction)
                            <td class='align-top text-right'>
                                <!-- mange submit winPrize --> 
                                @if(Auth::user()->can('agency-updateOrderDetail',$orderDetail->orderDetail)) 
                                <span id='span-{{$orderDetail->id}}-{{$noWin}}' class='inline-block float-right'>
                                    <span onclick="confirmFunctionSubmit(updateWinPrizeTraditional,[{{$orderDetail->id}},'{{config('laravelveso.winPrizeStatus.success.key')}}'],$message='Xác nhận?')" class="bg-green-500 text-white cursor-pointer rounded p-0 px-1 inline-block
                                                
                                    @if($orderDetail->options['winPrizeStatus'][0]==config('laravelveso.winPrizeStatus.success.key') || $orderDetail->options['winPrizeStatus'][0]==config('laravelveso.winPrizeStatus.contact.key'))
                                    hidden
                                    @endif
                                    ">Xác Nhận</span>
                                    <span onclick="confirmFunctionSubmit(updateWinPrizeTraditional,[{{$orderDetail->id}},'{{config('laravelveso.winPrizeStatus.cancel.key')}}'],$message='Xác nhận?')"  class="bg-red-500 text-white cursor-pointer rounded p-0 px-1 inline-block
                                    @if($orderDetail->options['winPrizeStatus'][0]==config('laravelveso.winPrizeStatus.cancel.key') )
                                    hidden
                                    @endif
                                    ">Hủy KQ</span>
                                </span>
                                <input type="hidden" class='winPrizes' value="updateWinPrizeTraditional-{{$orderDetail->id}}">
                                @endif    

                                <span class='text-red-500 italic block overflow-hidden pr-2' id='msg-{{$orderDetail->id}}'></span>
                            </td>
                            @endif
                        </tr>
                    </table>
                    @endif
                    <!-- ============ --> 
                </td>

            </table>   
        </td> 

        <td class='text-right '> 
            <!-- Auth::user()->can('agency-updateOrderDetail',$orderDetail->orderDetail) -->
            @if(Auth::user()->can('admin-updateOrderDetail'))    
                <!-- is refund all -> cannot click refund AdminOrderController.updateOrderDetail-->
                @if($orderDetail->qty_refund==$orderDetail->qty || $data["orderStatusValue"]==config("laravelveso.orderStatus.failure.key"))
                <span class='btn btn-danger float-right text-base w-20  p-1  disabled'>Đã hủy</span> 
                @else
                <span onClick="confirmFunctionSubmit(updateOrderDetail,[{{$orderDetail->id}},'canceled'],$message='Xác nhận?')" class='btn btn-danger float-right text-base w-20  p-1'>Hủy Vé</span>     
                @endif  

            @endif
    
        </td>
    </tr> 
</table> 




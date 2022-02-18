 
<?php
    use Phonglg\LaravelVeso\Helpers\Vietlott;

    $detail=$orderDetail->options;
    $orderDetailId=$orderDetail->id; 
?>

@if($detail['category']!='keno')   
<p>{{$data['methodsToPlay'][$detail['methodSelected']]['name']}}</p>
@endif

@if($detail['category']=='keno')   
<p>{{$data['methodsToPlayKeno'][$detail['methodSelected']]['name']}}</p>
@endif

@foreach ($detail['blocksNumber'] as $no=>$block)
    @if($block)
        <div>
            {{$data['blocks'][$no].": "}}

            <!-- case keno ChanLe-LonNho -->
            @if($detail['category']==config('laravelhtmldomparser.categoryType.keno.key') && $detail['methodSelected']>9 )   
                <?php $arr=$data['methodsToPlayKeno'][$detail['methodSelected']]['key'];?>
                @for($i=0;$i< count($block);$i++)
                    @if($block[$i]==1)
                        {{$arr[$i]}}
                        @break
                    @endif
                @endfor
            <!-- for other game -->
            @else 
                @foreach($block as $num)
                    {{$num}}
                @endforeach
            @endif

            <!-- show price for every block -->
            
            @if (isset($detail['priceBlocks'][$no]))
            - Giá: {{number_format($detail['priceBlocks'][$no])."Đ"}}
            @endif 
        </div> 
    @endif
@endforeach  

<?php 
$periods=$detail['buyingPeriods']; 
if(isset($detail['specificPeriods'])) $specificPeriods=$detail['specificPeriods']; 
$periodStatus=$detail['periodStatus']; 
?>
<table  class="w-full">
    <tr><th class='w-9/2'>Khách mua</th><th>Tình trạng</th><th class='text-right '>Chức năng</th></tr>
    @foreach ($periods as $no=>$period)
        <tr class="">
        @if($period)
            <td>
                @if(isset($specificPeriods) && isset($specificPeriods[$no]))
                    @if($detail['category']==config('laravelhtmldomparser.categoryType.keno.key'))
                        Chọn:  {{$period}} kỳ <br>
                        @foreach($specificPeriods[$no] as $noPeriod=>$valPeriod)
                            {{"Kỳ: ".$valPeriod}} (#{{($noPeriod+1)}}) <br>
                        @endforeach
                    @else
                        {{"Kỳ: ".$specificPeriods[$no]}} (#{{$period}})
                    @endif
                @else
                    {{"Kỳ: #".$period}}
                @endif

            </td>
           
            <td>{!! Vietlott::showperiodStatus($periodStatus[$no]) !!}</td>
            
            <td class='align-top  '>
                @can('admin-updateOrderDetail')
                    <span onClick="confirmFunctionSubmit(updateOrderDetail,['{{$orderDetailId}}#{{$no}}','refund'],$message='Xác nhận?')" class='btn btn-danger float-right
                    @if($periodStatus[$no]==config("laravelveso.buyingPeriodsStatus.refund.0") ||
                    $data["orderStatusValue"]==config("laravelveso.orderStatus.failure.key"))
                        disabled
                    @endif  
                    '>Hoàn tiền</span>  
                @endcan
            </td> 
            
        @endif
        </tr>
    @endforeach
</table>
 

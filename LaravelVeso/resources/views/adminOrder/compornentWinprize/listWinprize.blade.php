<?php 
use Phonglg\LaravelVeso\Helpers\Vietlott;
?> 

@if(count($winPrizes)>0)
    <div class="overflow-x-scroll ">
        <table class="table">
            <tr class='listTable'>
                <th>#</th>
                <th class='hidden'>ID</th>
   
                <th
                @if($data['ticketType'] == config('laravelveso.ticketTypes.vietlott.key'))
                hidden
                @endif
                >Đại lý </th>  
                <th class="w-20 ">#HD(CTHD)</th> 

                <th 
                @if($data['ticketType'] != config('laravelveso.ticketTypes.vietlott.key'))
                hidden
                @endif
                >Loại vé</th> 

                <th class='hidden'>Status</th> 
                <th>Giải thưởng
                <input onclick="confirmFunctionSubmit(submitAllWinPrize,['{{config('laravelveso.winPrizeStatus.success.key')}}'],$message='Xác nhận?')" class='actionBtn  border rounded bg-green-500 text-white float-right px-2 py-1 cursor-pointer' type="button" value='Xác nhận tất cả' />
                <input onclick="confirmFunctionSubmit(submitAllWinPrize,['{{config('laravelveso.winPrizeStatus.cancel.key')}}'],$message='Xác nhận?')" class='actionBtn  border rounded bg-red-500 text-white float-right px-2 py-1 cursor-pointer' type="button" value='Hủy KQ tất cả' />
                </th>   
            </tr>  
            @foreach($winPrizes as $no=>$winPrize)
            <tr>
                <td>{{$no+1}}</td> 
                <td class='hidden'>
                    {{$winPrize->id}}
                </td> 
         
                <td
                @if($data['ticketType'] == config('laravelveso.ticketTypes.vietlott.key'))
                hidden
                @endif
                >
                    @if($winPrize->agency)
                    {{$winPrize->agency->agency_name}}
                    @endif
                </td>  
                <td> 
                    @if(Auth::user()->role_id < config('laraveluserrole.defaultRoleId')) 
                        <a target='_blank' class='text-blue-500' href="{{route('admin.order.show',['order'=>$data['orderDetais'][$no]->order_id])}}">
                        #{{$data['orderDetais'][$no]->order_id}}({{$data['orderDetais'][$no]->id}})
                        </a>
                    @else
                        <a target='_blank'  class='text-blue-500' href="{{route('customer.order.show',['order'=>$data['orderDetais'][$no]->order_id])}}">
                        #{{$data['orderDetais'][$no]->order_id}}({{$data['orderDetais'][$no]->id}})
                        </a>
                    @endif

                </td>
                <td class='winPrizeStatus-{{$winPrize->status}} hidden'>
                    @if(config('laravelveso.winPrizeStatus.'.$winPrize->status.'.label'))
                    {{config('laravelveso.winPrizeStatus.'.$winPrize->status.'.label')}} 
                    @else
                    {{config('laravelveso.winPrizeStatus.pendding.label')}} 
                    @endif
                </td> 

                
                @if($winPrize->ticket_type==config('laravelveso.ticketTypes.traditionallottery.key'))
                <td>
                    @include('laravelveso::adminOrder.componentOrder.traditionalDetail',['orderDetail'=>$data['orderDetais'][$no]])
                </td>
                <!-- for vietllot -->
                @else
                    <?php 
                        $orderDetail=$data['orderDetais'][$no];
                        $detail=$orderDetail->options;
                        $orderDetailId=$orderDetail->id; 
                        $periods=$detail['buyingPeriods']; 
                        $periodStatus=$detail['periodStatus']; 
                        if(isset($detail['specificPeriods'])) $specificPeriods=$detail['specificPeriods']; 
                        $noPeriod=$winPrize->noPeriod;
                        $period=$periods[$noPeriod];
                    ?>

                    <td class="w-20 ">
                        <!-- {{config('laravelhtmldomparser.categoryType.'.$winPrize->ticket_type.'.name')}} -->
                        <img src="{{ url($orderDetail->options['image']) }}" alt="" class="w-20 ">
                    </td> 

                    <td>
                        <table  class="w-full">
                            
                            <tr><th class='w-9/2'>Khách mua</th> <th class='text-right'>Chức năng </th></tr> 
                            @include('laravelveso::adminOrder.componentOrder.vietlottDetailPeriod')  
                        </table>
                    </td> 
                @endif
            </tr>
            @endforeach
        </table>  
    </div>
    @endif
    
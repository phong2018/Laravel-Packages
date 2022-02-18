<?php 
use Phonglg\LaravelVeso\Helpers\Vietlott;
?>

@if(count($orders)>0)
    <div class="overflow-x-scroll ">
        <table class="table">
            <tr class='listTable'>
                <th>#</th>
                <th>ID</th>
                <th>Tình trạng</th> 
                <th>Loại hóa đơn</th> 
                <th>Thanh toán</th> 
                <th>Phí chuyển tiền</th> 
                <th>Tổng hóa đơn</th> 
                <th>Tổng tiền hoàn</th>
                <th>Bank</th> 
                <th>Ngày tạo</th> 
                <th class="text-right">Chức năng</th>
                
            </tr>  
            @foreach($orders as $no=>$order)
            <tr>
                <!-- Form quick Edit  -->
                <td>{{ $no+1}}</td> 
                <td>{{$order->id}}</td> 
                <td>{!! Vietlott::showOrderStatus($order->status) !!}</td>  
                <td><span class='font-{{$order->type}}'>{{config('laravelveso.orderTypes.'.$order->type.'.label')}}</span></td> 
                <td>{{number_format($order->total-$order->bank_transfer_fee)}}</td> 
                <td>{{number_format($order->bank_transfer_fee)}}</td> 
                <td>{{number_format($order->total)}}</td> 
                <td>{{number_format($order->total_refund)}}</td> 
                <td>{{$order->bank_code}}</td> 
                <td>{{date("d/m/Y H:i:s", strtotime($order->created_at))}}</td>   

                <!-- End Form quick Edit  -->

                <td class='text-right'>
                @if($order->type==config('laravelveso.orderTypes.buyLottery.key'))
                <a class='btn btn-info' href="{{route('admin.order.show',['order'=>$order])}}"><i class="far fa-eye"></i></a>
                @else 
                <a class='btn btn-info' href="{{route('admin.point.show',['order'=>$order])}}"><i class="far fa-eye"></i></a>
                @endif    
            </td>
               
            </tr>
            @endforeach
        </table>  
    </div>
    @endif
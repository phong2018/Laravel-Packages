<?php 
use Phonglg\LaravelVeso\Helpers\Vietlott;
?> 
@if($orders->count()>0)
<div class="overflow-x-scroll ">
    <table class="table">
        <tr class='listTable'>
            <th>#</th>
            <th class="text-center">Chức năng</th>
            <th>ID</th>
            <th>Tình trạng</th> 
            <th>Loại hóa đơn</th> 
            <th>Thanh toán</th> 
            <th>Phí chuyển tiền</th> 
            <th>Tổng hóa đơn</th> 
            <th>Ngày tạo</th>  
            
        </tr>  
        @foreach($orders as $no=>$order)
        <tr>
            <!-- Form quick Edit  -->
            <td>{{ $no+1}}</td> 
            <!-- End Form quick Edit  --> 
            <td class='text-right'>
            <a class='' href="{{route('point.show',['order'=>$order])}}"><i class="far fa-eye"></i></a>
            </td>
            <td>{{$order->id}}</td> 
            <td>{!! Vietlott::showOrderStatus($order->status) !!}</td> 
            <td>{{config('laravelveso.orderTypes.'.$order->type.'.label')}}</td> 
            <td>{{number_format($order->total-$order->bank_transfer_fee)}}</td> 
            <td>{{number_format($order->bank_transfer_fee)}}</td> 
            <td>{{number_format($order->total,0)}}</td>  
            <td>{{date("d/m/Y H:i:s", strtotime($order->created_at))}}</td>   
            
        </tr>
        @endforeach
    </table> 
    {{ $orders->links() }}
</div>
@endif 
  
<?php 
use Phonglg\LaravelVeso\Helpers\Vietlott;
if(!isset($template))$template=config('laravelveso.layoutAgency')
?>

@extends($template)

@section('content')
<div class="mx-auto">
     <h1 class="pagetitle">Danh sách hóa đơn</h1>
     @if(session('message'))
          <div class="alert alert-success">
               <p class="m-0">{{session('message')}}</p>
          </div>
     @endif

     @if($orders->count()>0)
    <div class="overflow-x-scroll ">
        <table class="table">
            <tr class='listTable'>
                <th>#</th>
                <th class="text-right">Chức năng</th>
                <th>ID</th>
                <th>Tình trạng</th> 
                <th>Loại hóa đơn</th> 
                <th>Thanh toán</th> 
                <th>Phí chuyển</th> 
                <th>Tổng hóa đơn</th> 
                <th>Ngày tạo</th> 
                
            </tr>  
            @foreach($orders as $no=>$order)
            <tr>
                <!-- Form quick Edit  -->
                <td>{{ $no+1}}</td> 
                <!-- End Form quick Edit  -->
                <td class='text-right'>
                <a title='Xem chi tiết' class='' title='show detail' 
                @if(Auth::user()->role_id < 3)
                    href="{{route('admin.order.show',['order'=>$order])}}"
                @else
                    href="{{route('customer.order.show',['order'=>$order])}}"
                @endif
                ><i class="far fa-eye"></i></a> 
                </td>
                <td>{{$order->id}}</td> 
                <td>
                    {!! Vietlott::showOrderStatus($order->status) !!}
                    
                    @if($order->status==config('laravelveso.orderStatus.pendding.key'))
                        <a title='Thanh toán' class='' title='Checkout' href="{{route('order.vnpay_payOrder',['order'=>$order])}}"><i class="fas fa-money-bill-wave mr-3"></i></a> 
                    @endif
                </td>  
                <td>{{config('laravelveso.orderTypes.'.$order->type.'.label')}}</td> 
                <td>{{number_format($order->total-$order->bank_transfer_fee)}}</td> 
                <td>{{number_format($order->bank_transfer_fee)}}</td> 
                <td>{{number_format($order->total)}}</td> 
                <td>{{date("d/m/Y H:i:s", strtotime($order->created_at))}}</td>   
               
            </tr>
            @endforeach
        </table> 
        {{ $orders->links() }}
    </div>
    @endif
    @include('laravellayout::partial.popup.formConfirm') 
</div>
@endsection
 
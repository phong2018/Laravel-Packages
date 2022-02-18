<?php 
use Phonglg\LaravelVeso\Helpers\Vietlott;
?> 
@extends($template)

@section('content')
<div class="mx-auto">
    
    <h1 class="pagetitle">Đổi điểm tích lũy</h1>

    @if(session('message'))
          <div class="alert alert-success">
               <p class="m-0">{{session('message')}}</p>
          </div>
     @endif
     
    <div class="overflow-x-scroll ">
        <table class="table">
            <tr class='listTable'>
                <th>#</th> 
                <th>ID</th>
                <th>Chức năng</th>
                <th>Tình trạng</th>   
                
                <th>Yêu cầu</th>  
                <th>Loại Yêu cầu</th>  
                <th>Điểm</th>  
                <th>Khách hàng</th>  
                <th>Ngày tạo</th>  
                
            </tr>  
            @foreach( $data['ordersAccumulatePoint'] as $no=>$order)
            <tr>
                <!-- Form quick Edit  -->
                <td>{{ $no+1}}</td>  
                <td>{{$order->id}}</td> 
                <td>
    
                    <form title='Cập nhật' class="inline" id="formSuccess{{$order->id}}" method="POST"  action="{{route('admin.updateOrderWithdrawPointAccumulate')}}">
                        @csrf 
                        <input type="hidden" name='status' value="success"/>
                        <input type="hidden" name='orderId' value="{{$order->id}}"/>
                        
                        <button type="submit" onClick="confirmFormSubmit('formSuccess{{$order->id}}')" class="p-1
                            @if($order->status=='success') 
                            hidden
                            @endif
                        ">
                        <span class='p-1 border rounded bg-blue-400 text-white'>Xác Nhận</span>
                        </button>
 
                    </form> 

                    <form title='Cập nhật' class="inline" id="formFailure{{$order->id}}" method="POST"  action="{{route('admin.updateOrderWithdrawPointAccumulate')}}">
                        @csrf  
                        <input type="hidden"  name='status' value="failure"/>
                        <input type="hidden" name='orderId' value="{{$order->id}}"/>
                        <button type="submit" onClick="confirmFormSubmit('formFailure{{$order->id}}')" class="p-1
                            @if($order->status=='failure') 
                            hidden
                            @endif
                        ">
                        <spans class='p-1 border rounded bg-red-400  text-white'>Hủy</spans>
                        </button>
                    </form> 
    
                </td>
                <td>{!! Vietlott::showOrderStatus($order->status) !!}</td> 
                <td>{{$order->notes}}</td>  
                <td>{{config('laravelveso.orderTypes.'.$order->type.'.label')}}</td>  
                <td>{{number_format($order->total,0)}}</td>  
                <td>{{$order->user->username}}</td>  
                <td>{{date("d/m/Y H:i:s", strtotime($order->created_at))}}</td>   
                
            </tr>
            @endforeach
        </table> 
        {{  $data['ordersAccumulatePoint']->links() }}
    </div>
</div>
@include('laravellayout::partial.popup.formConfirm') 
@endsection
 
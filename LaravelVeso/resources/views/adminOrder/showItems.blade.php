<?php
use Phonglg\LaravelVeso\Helpers\Vietlott;
?>
<div class="overflow-x-scroll"> 
    <table class="table ">
        <tr>
            <td><p>Mã hóa đơn: <span class='font-bold'> #{{$data['orderId']}} - Ngày: {{date("d-m-Y H:i:s", strtotime($data['dateAdded'])) }}</span></p>
            <p>Khách hàng: 
                @if(Auth::user()->role_id < 3)
                    <a class='text-blue-500' href="{{route('customers.customerLog',['customer'=>$data['customerId']])}}" target='_blank'>
                    {{$data['customerInfo']}}
                    </a>
                @else 
                    {{$data['customerInfo']}}
                @endif
            </p>
            <p>Tình trạng: <span class="text-blue-500">{{$data['orderStatus']}}</span></p>
            
            @if(Auth::user()->role_id < 3 || ($data['customerId']==Auth::id()) )
                <p>Tổng tiền vé: <span class='font-bold'>{{number_format($data['total']-$data['bank_transfer_fee'])}}Đ</span></p>
                <p>Tổng thanh toán = {{number_format($data['total']-$data['bank_transfer_fee'])}} (tiền vé) + {{number_format($data['bank_transfer_fee'])}} (phí chuyển tiền) = <span class='font-bold'>{{number_format($data['total'])}}Đ</span></p>
                <p>Tổng tiền hoàn: <span class='font-bold'>{{number_format($data['tempRefundTotal'])}}Đ</span></p></td> 
            @endif

        </tr>
 
        
        @foreach ($cart as $rowId=>$orderDetail) 
            @if($orderDetail->options['category']==config('laravelhtmldomparser.categoryType.traditionallottery.key'))
                @if(Auth::user()->role_id < 3 || ($data['customerId']==Auth::id()) || ($orderDetail->options['agency_id']==Auth::id()) )
                <tr style="border-top:3px solid #d0d0d0"><td>
                <div id='mgsUpdate{{$orderDetail->id}}'></div>
                    @include('laravelveso::adminOrder.componentOrder.traditionalDetail',['showFunction'=>false]) 
                </td></tr>
                @endif
            @else
                @if(Auth::user()->role_id < 3 || ($data['customerId']==Auth::id()) )
                <tr style="border-top:3px solid #d0d0d0"><td>
                <div id='mgsUpdate{{$orderDetail->id}}'></div>
                    @include('laravelveso::adminOrder.componentOrder.vietlottDetail',['showFunction'=>false])
                </td></tr>
                @endif
            @endif
        @endforeach
        
    </table> 
</div>  
@include('laravelveso::adminOrder.componentOrder.ajaxScriptUploadFile') 
@include('laravelveso::adminOrder.componentOrder.scriptUpdateOrderDetail') 
@include('laravellayout::partial.popup.functionConfirm') 


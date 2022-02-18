<?php
use Phonglg\LaravelVeso\Helpers\Vietlott;
?>
<div class="overflow-x-scroll"> 
    <table class="table ">
        <tr>
            <td colspan='4'>Mã hóa đơn: #{{$data['orderId']}} - Ngày: {{$data['dateAdded']}}</td>
        </tr>
 
         <tr>
            <td colspan='4'>Tình trạng: <strong>{{$data['orderStatusLabel']}}</strong></td>
        </tr>
        <tr>
            <td colspan='4'>Khách hàng: {{$data['customerInfo']}}</td>
        </tr>
        <tr>
            <td colspan='4'>TK Ngân hàng: <span class='text-red-500'>{{$data['bankInfo']}}</span></td>
        </tr>

        
        <tr>
            <td colspan='4'>Tổng tiền yêu cầu rút:<span  class='font-bold'> {{number_format($data['total'])}}Đ</span></td>
        </tr>  
    </table>  

    <span onClick="confirmFunctionSubmit(updateOrderStatus,[{{$data['orderId']}},'{{ config('laravelveso.orderStatus.paid.key')}}'],$message='Xác nhận?')" class="btn btn-success float-right
        @if($data['orderStatus']==config('laravelveso.orderStatus.paid.key'))
        disabled
        @endif  
    ">Xác nhận Rút tiền</span> 

    <span onClick="confirmFunctionSubmit(updateOrderStatus,[{{$data['orderId']}},'{{ config('laravelveso.orderStatus.pendding.key')}}'],$message='Xác nhận?')" class="btn btn-danger float-right  mr-1
        @if($data['orderStatus']==config('laravelveso.orderStatus.pendding.key'))
        disabled
        @endif  
    ">Hủy Rút tiền</span>
</div> 
<script>
    // axios call
    function updateOrderStatus(data){  
        // alert(data);
        orderId=data[0];
        status=data[1];
        axios.post("{{ $data['updateOrderWithdrawPoint'] }}",{
            'orderId':orderId,'status':status
            })
            .then((response) => {  
                console.log(response); 
                location.reload();
            })
            .catch((error) => {
                 console.log(error);
            }); 
    } 
</script>
@include('laravellayout::partial.popup.functionConfirm') 


<?php
use Phonglg\LaravelVeso\Helpers\Vietlott;
?>
<div  id='mgsUpdate'></div>

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
            <td colspan='4'>Tổng tiền nạp: {{number_format($data['total']-$data['bank_transfer_fee'])}}Đ</td>
        </tr> 
        
        <tr>
            <td colspan='4'>Tổng thanh toán = {{number_format($data['total']-$data['bank_transfer_fee'])}}Đ (tiền nạp) + {{number_format($data['bank_transfer_fee'])}}Đ (phí chuyển tiền) = {{number_format($data['total'])}}Đ</td>
        </tr>
          
    </table>  

    <span onClick="confirmFunctionSubmit(updateOrderStatus,[{{$data['orderId']}},'{{ config('laravelveso.orderStatus.paid.key')}}'],$message='Xác nhận?')" class="disabledWhenSubmit btn btn-success float-right
        @if($data['orderStatus']==config('laravelveso.orderStatus.paid.key'))
        disabled
        @endif  
    ">Xác nhận Nạp tiền</span> 

    <span onClick="confirmFunctionSubmit(updateOrderStatus,[{{$data['orderId']}},'{{ config('laravelveso.orderStatus.pendding.key')}}'],$message='Xác nhận?')" class="disabledWhenSubmit btn btn-danger float-right  mr-1
        @if($data['orderStatus']==config('laravelveso.orderStatus.pendding.key'))
        disabled
        @endif  
    ">Hủy Nạp tiền</span>
</div> 
<script>
    // axios call
    function updateOrderStatus(data){  
        $(".disabledWhenSubmit" ).addClass( "disabled", 'disabled' ); 
        // alert(data);
        orderId=data[0];
        status=data[1];
        axios.post("{{ $data['updateOrderAddPoint'] }}",{
            'orderId':orderId,'status':status
            })
            .then((response) => {  
                console.log(response['data']); 
                if(response['data']['error']) 
                $('#mgsUpdate').html("<div class='alert alert-danger block'>"+response['data']['error']+"</div>");
                else location.reload();

            })
            .catch((error) => {
                console.log(error);
            }); 
    } 
</script>
@include('laravellayout::partial.popup.functionConfirm') 


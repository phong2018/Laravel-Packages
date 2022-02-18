@extends(config('laravelveso.layout'))

@section('content')
<div class="mx-auto">
     <h1 class="pagetitle">Thông tin nạp tiền</h1> 
     
     @if(session('message'))
          <div class="alert alert-success">
               <p class="m-0">{{session('message')}}</p>
          </div>
     @endif 

     @if(session('error'))
          <div class="alert alert-danger">
               <p class="m-0">{{session('error')}}</p>
          </div>
     @endif

     <div class="overflow-x-scroll"> 
     <table class="table ">
          <tr>
               <td colspan='4'>Mã hóa đơn: #{{$data['orderId']}} - Ngày: {{$data['dateAdded']}}</td>
          </tr>
     
          <tr>
               <td colspan='4'>Tình trạng: {{$data['orderStatus']}}</td>
          </tr>
          <tr>
               <td colspan='4'>Khách hàng: {{$data['customerInfo']}}</td>
          </tr>
          <tr>
               <td colspan='4'>Tổng tiền nạp: <span  class='font-bold'>  {{number_format($data['total']-$data['bank_transfer_fee'])}}Đ</span></td>
          </tr> 
          
          <tr>
               <td colspan='4'>Tổng thanh toán = {{number_format($data['total']-$data['bank_transfer_fee'])}} (tiền nạp) + {{number_format($data['bank_transfer_fee'])}} (phí chuyển tiền) = <span  class='font-bold' >{{number_format($data['total'])}}Đ</span></td>
          </tr>  
          
     </table> 
     </div>   
</div>
@endsection
 
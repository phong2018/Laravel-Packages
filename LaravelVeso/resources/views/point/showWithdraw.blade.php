@extends(config('laravelveso.layoutAgency'))

@section('content')
<div class="mx-auto">
     <h1 class="pagetitle">Thông tin rút tiền</h1> 
     
     @if(session('message'))
          <div class="alert alert-success">
               <p class="m-0">{{session('message')}}</p>
          </div>
     @endif 

     <div class="overflow-x-scroll"> 
     <table class="table ">
          <tr>
               <td colspan='4'>Mã yêu cầu: #{{$data['orderId']}} - Ngày: {{$data['dateAdded']}}</td>
          </tr>
     
          <tr>
               <td colspan='4'>Tình trạng: {{$data['orderStatus']}}</td>
          </tr>
          <tr>
               <td colspan='4'>Khách hàng: {{$data['customerInfo']}}</td>
          </tr>
          <tr>
               <td colspan='4'>Tổng tiền yêu cầu rút: <span  class='font-bold'>  {{number_format($data['total'])}}Đ</span></td>
          </tr> 
          
          
          
     </table> 
     </div>   
</div>
@endsection
 
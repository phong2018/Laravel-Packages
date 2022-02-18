<?php 
use Phonglg\LaravelVeso\Helpers\Vietlott;
?>

@extends(config('laravelveso.layoutAgency'))

@section('content') 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<div class="mx-auto">
     <h1 class="pagetitle">Danh sách Nạp tiền & Rút tiền</h1>
     <a class='btn btn-primary float-rights text-white mb-2' href="{{route('point.add')}}">Nạp tiền</a>
     <a class='btn btn-warning float-rights text-black mb-2' href="{{route('point.withdraw')}}">Rút tiền</a>
     
     <!-- message -->
     @if(session('message'))
          <div class="alert alert-success pt-2">
                <p class="m-0 text-red-400 font-bold">{{session('message')}}</p>
                <p>Thanh toán trực tiếp tại cửa hàng.</p>
                <p>Hoặc chuyển tiền vào tài khoản:</p>
                <div class="alert alert-danger mb-2 mt-2">
                    <p>{!! session('bankMessage') !!} </p>
                    <p>Nội dung chuyển khoảng: <span class='font-bold'>TTHĐ #{{session('orderId')}}</span></p>
               </div>
          </div>
     @endif 

     <!-- messageWithdrawStore -->
     @if(session('messageWithdrawStore'))
          <div class="alert alert-success pt-2">
          <p class="m-0 text-red-400 font-bold">{{session('messageWithdrawStore')}}</p>
          </div>
     @endif   

    <!-- list add point and withdraw point --> 
    <ul class="nav nav-tabs p-0" role="tablist">
        <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#listAddPoint">Nạp tiền</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#listWithdrawPoint">Rút Tiền</a>
        </li> 
    </ul> 
    <div class="tab-content p-0">
        <div id="listAddPoint" class="container tab-pane active p-0"> 
            @include('laravelveso::point.listAddPoint',['orders'=>$data['ordersAddPoint']])
        </div>
        <div id="listWithdrawPoint" class="container tab-pane fade p-0"> 
            @include('laravelveso::point.listWithdrawPoint',['orders'=>$data['ordersWithdrawPoint']])
        </div> 
    </div> 

</div>

     



           

@endsection
 
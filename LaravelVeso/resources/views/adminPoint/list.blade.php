<?php 
use Phonglg\LaravelVeso\Helpers\Vietlott;
?>
@extends(config('laravelveso.layoutAdmin'))

@section('content')
<div class="mx-auto">
     <h1 class="pagetitle">Danh sách Nạp tiền & Rút tiền</h1>
     @if(session('message'))
          <div class="alert alert-success">
               <p class="m-0">{{session('message')}}</p>
          </div>
     @endif 
     <!-- form -->
     <form action="{{$data['actionInvoiceStatistics']}}" method="GET"  enctype="multipart/form-data" class='overflow-hidden p-2 mb-2 bg-gray-100'>
         @include('laravelveso::component.formFromToDate',['actionFrom'=>$data['actionInvoiceStatistics'],'fromDate'=>date("d-m-Y", strtotime($data['invoiceStatistics']['fromDate'])),'toDate'=>date("d-m-Y", strtotime($data['invoiceStatistics']['toDate']))])  
         
         @if(Auth::user()->role_id<3)
            @include('laravellayout::componentsFilter.formSelect',['name'=>'payment','label'=>'Thanh toán','listItem'=>$data['payments'],'keyValue'=>'keyValue','keyName'=>'keyName','selectedItem'=>$data['payment'],'message'=>($errors->has('payment'))?$errors->first('payment'):'','classLabel'=>'w-5/12 md:w-4/12','classInput'=>'w-7/12 md:w-8/12 float-right'])

            @include('laravellayout::componentsFilter.formSelect',['name'=>'orderType','label'=>'Nạp/Rút','listItem'=>$data['orderTypes'],'keyValue'=>'keyValue','keyName'=>'keyName','selectedItem'=>$data['orderType'],'message'=>($errors->has('orderType'))?$errors->first('orderType'):'','classLabel'=>'w-5/12 md:w-4/12','classInput'=>'w-7/12 md:w-8/12 float-right'])
         @endif

         <div  class='p-1 inline'>
            <button type="submit" class="bg-blue-500  p-1  text-white rounded-lg">Thống Kê</button>
        </div>  
    </form>
     @if($orders->count()>0) 
        <div class='statictisData overflow-hidden'> 
            <div class='w-full md:w-1/2 float-left'>
                <p class='pb-0'>Tổng số yêu cầu Nạp tiền: <span class=' font-bold'>{{$data['statisticsOrders'][0]}} </span></p>
                <p class='pb-2'>Tổng doanh số Nạp: <span class=' font-bold'>{{number_format($data['statisticsOrders'][1])}}Đ</span>  </p>
            </div>
            <div class='w-full md:w-1/2 float-right'>
               <p class='pb-0'>Tổng số yêu cầu Rút tiền: <span class=' font-bold'>{{$data['statisticsOrders'][2]}} </span></p>
                <p class='pb-2'>Tổng doanh số Rút: <span class=' font-bold'>{{number_format($data['statisticsOrders'][3])}}Đ</span>  </p>
            </div> 
        </div> 

        @include('laravelveso::component.listOrder',['orders'=>$orders])
    @endif
    @include('laravellayout::partial.popup.formConfirm') 
</div>
@endsection
 
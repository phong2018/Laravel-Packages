<?php 
use Phonglg\LaravelVeso\Helpers\Vietlott;
?>

@extends(config('laravelveso.layoutAdmin'))

@section('content')
<div class="mx-auto">
     <h1 class="pagetitle">Danh Sách Hóa Đơn</h1>
     @if(session('message'))
          <div class="alert alert-success">
               <p class="m-0">{{session('message')}}</p>
          </div>
     @endif
     <!-- form -->
     <form action="{{$data['actionInvoiceStatistics']}}" method="GET"  enctype="multipart/form-data" class='overflow-hidden p-2 mb-2 bg-gray-100'>
        @include('laravelveso::component.formFromToDate',['actionFrom'=>$data['actionInvoiceStatistics'],'fromDate'=>date("d-m-Y", strtotime($data['invoiceStatistics']['fromDate'])),'toDate'=>date("d-m-Y", strtotime($data['invoiceStatistics']['toDate']))])  
        <div  class='p-1 inline'>
            <button type="submit" class="bg-blue-500  p-1  text-white rounded-lg">Thống Kê</button>
        </div>  
    </form>

     @if($orders->count()>0)
        <div class='statictisData overflow-hidden'> 
            <div class='w-full md:w-1/2 float-left'>
                <p class='pb-0'>Tổng số hóa đơn: <span class=' font-bold'>{{$orders->count()}} </span></p>
                <p class='pb-2'>Tổng doanh số: <span class=' font-bold'>{{number_format($data['totalSaleOrder'])}}Đ</span>  </p>
            </div>
            <div class='w-full md:w-1/2 float-right'>
                <p class='pb-0'>Tổng số hóa đơn hoàn lại: <span class=' font-bold'>{{$data['countOrderRefund']}} </span></p>
                <p class='pb-2'>Tổng số tiền hoàn: <span class=' font-bold'>{{number_format($data['totalOrderRefund'])}}Đ</span>  </p>
            </div> 
        </div>

        @include('laravelveso::component.listOrder',['orders'=>$orders])

    @endif
    @include('laravellayout::partial.popup.formConfirm') 
</div>
@endsection
 
<?php 
use Phonglg\LaravelVeso\Helpers\Vietlott;
?> 
@extends(config('laravelveso.layoutAgency'))

@section('content')
<div class="mx-auto">
    <h1 class="pagetitle">Đổi điểm tích lũy</h3>
     @if(session('message'))
          <div class="alert alert-success">
               <p class="m-0">{{session('message')}}</p>
          </div>
     @endif

     <div class="bg-white md:bg-white md:flex"> 

        <div class="w-full">  

            <form action="{{route('point.withdrawAccumulatePoint.store')}}" method="POST" enctype="multipart/form-data" class='overflow-hidden'>
                @csrf
                
                <x-laravelcomponent-forminput name="point" classLabel='w-4/12 md:w-3/12' classInput='viewCommasNumber w-full md:w-full float-right'  value="{{old('point','1')}}" label="số điểm đổi(*)" type="text" message="{{($errors->has('point'))?$errors->first('point'):''}}" />    
                    
                @include('laravellayout::components.formTextarea',['name'=>'notes','classLabel'=>'hidden w-4/12 md:w-3/12','classInput'=>'w-full md:w-full float-right', 'value'=>old('notes'),'label'=>'Yêu cầu đổi thưởng/ tham gia chương trình','message'=>($errors->has('notes'))?$errors->first('notes'):''])
 
                <button type="submit" class="bg-blue-500 w-30 p-2 text-white rounded-lg float-right">Gửi yêu cầu</button>
        
            </form>
        </div>
    </div>
</div> 
@include('laravellayout::script.scriptCommasNumber',['idInputNumber'=>'point','stepNum'=>1]) 

<h1 class='text-xl py-1'>Danh sách yêu cầu</h1>
<div class="overflow-x-scroll ">
    <table class="table">
        <tr class='listTable'>
            <th>#</th> 
            <th>ID</th>
            <th>Tình trạng</th>   
            
            <th>Yêu cầu</th>  
            <th>Loại Yêu cầu</th>  
            <th>Điểm</th>  
            <th>Ngày tạo</th>  
            
        </tr>  
        @foreach( $data['ordersAccumulatePoint'] as $no=>$order)
        <tr>
            <!-- Form quick Edit  -->
            <td>{{ $no+1}}</td>  
            <td>{{$order->id}}</td> 
            <td>{!! Vietlott::showOrderStatus($order->status) !!}</td> 
            <td>{{$order->notes}}</td>  
            <td>{{config('laravelveso.orderTypes.'.$order->type.'.label')}}</td>  
            <td>{{number_format($order->total,0)}}</td>  
            <td>{{date("d/m/Y H:i:s", strtotime($order->created_at))}}</td>   
            
        </tr>
        @endforeach
    </table> 
    {{  $data['ordersAccumulatePoint']->links() }}
</div>

@endsection
 
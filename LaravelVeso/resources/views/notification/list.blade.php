<?php 
use Phonglg\LaravelVeso\Helpers\Vietlott;
?>

@extends($template)

@section('content') 
<div class="mx-auto">
     <h1 class="pagetitle">Danh sách Thông báo</h1> 

     @if($notifications->count()>0)
    <div class="overflow-x-scroll ">
        <table class="table">
            <tr class='listTable'>
                <th>#</th> 
                <th class='text-center'>Chi tiết</th> 
                <th>Nội dung</th>  
                <th>Ngày tạo</th>  
                
            </tr>  
            @foreach($notifications as $no=>$notification)
            <tr>
                <!-- Form quick Edit  -->
                <td>{{ $no+1}}</td> 
                <!-- End Form quick Edit  --> 
                <td class='text-center'>
                @if($notification->read_at) 
                    <p>Đã xem</p>
                    {{date("d/m/Y", strtotime($notification->read_at))}} 
                @endif
                <p><a class='text-blue-500' href="{{route('winPrizeNotification.show',['notification'=>$notification->id])}}">Xem</a></p>
                </td>  
                <td>{!! $notification->data['message']['title'] !!}</td>   
                <td>{{date("d/m/Y H:i:s", strtotime($notification->created_at))}}</td>   
               
            </tr>
            @endforeach
        </table> 

        {{ $notifications->links() }}
    </div>
    @endif 
</div>

@endsection
 
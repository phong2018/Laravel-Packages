
<?php
use Phonglg\LaravelSetting\Helpers\SettingHelper;
?>
@extends($data['template'])

@section('content')
<div class="mx-auto">
    <h1 class="pagetitle">Danh sách Khách hàng đã giới thiệu</h1> 

    <p class='pb-1'>Url giới thiệu khách hàng: <a class='text-blue-500' href="">{{route('register')}}?p={{Auth::user()->username}}</a></p>
    <p class='pb-3'> <a href="{{SettingHelper::getKey('url_affiliate_marketing_commission_policy')}}">>> Xem chi tiết về chính sách hoa hồng tiếp thị liên kết</a></p>


     @if($data['customers']->count()>0)
    <div class="overflow-x-scroll ">
        <table class="table">
            <tr class='listTable'>
                <th>STT</th>
                <th>Username</th>   
                <th>Ngày đăng ký</th>  
            </tr>  
            @foreach($data['customers'] as $no=>$val)
            <tr>
                <!-- Form quick Edit  -->
                <td>{{ $no+1}}</td> 
                <td>{{$val->username}}</td>  

                <td>{{date("d/m/Y H:i:s", strtotime($val->created_at))}}</td>  
             
            </tr>
            @endforeach
        </table> 
        {{ $data['customers']->links() }}
    </div>
    @endif 
</div>

@endsection
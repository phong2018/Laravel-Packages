<?php
use Phonglg\LaravelSetting\Helpers\SettingHelper;
?>
@extends(config('laravelauth.layout'))

@section('content')
<h1 class="pagetitle">Đăng Ký tài khoản</h1>
<form action={{ route('register') }} method="post" class='formLogin'>
    @csrf

    <x-laravelcomponent-forminput required='required' classLabel='hidden md:w-3/12 md:inline-block ' classInput='w-full md:w-9/12 float-right'   name="username" value="{{old('username')}}" label="Số điện thoại"  type="text" message="{{($errors->has('username'))?$errors->first('username'):''}}" />

    <x-laravelcomponent-forminput required='required' classLabel='hidden md:w-3/12 md:inline-block ' classInput='w-full md:w-9/12 float-right'   name="name" value="{{old('name')}}" label="Họ tên" type="text" message="{{($errors->has('name'))?$errors->first('name'):''}}" />

    <x-laravelcomponent-forminput  classLabel='hidden md:w-3/12 md:inline-block ' classInput='w-full md:w-9/12 float-right'   name="identity_card_number" value="{{old('identity_card_number')}}" label="CMND" type="text" message="{{($errors->has('identity_card_number'))?$errors->first('identity_card_number'):''}}" />

    <x-laravelcomponent-forminput  classLabel='hidden md:w-3/12 md:inline-block ' classInput='w-full md:w-9/12 float-right'   name="email" value="{{old('email')}}" label="Email" type="text" message="{{($errors->has('email'))?$errors->first('email'):''}}" /> 
 
    <x-laravelcomponent-forminput  required='required' classLabel='hidden md:w-3/12 md:inline-block ' classInput='w-full md:w-9/12 float-right'   name="password" value="" label="Mật khẩu" type="password" message="{{($errors->has('password'))?$errors->first('password'):''}}" />

    <x-laravelcomponent-forminput  required='required' classLabel='hidden md:w-3/12 md:inline-block ' classInput='w-full md:w-9/12 float-right'   name="password_confirmation" value="" label="Nhập lại MK" type="password_confirmation" message="" />

    @include('laravellayout::components.captcharInput',['classLabel'=>'hidden md:w-3/12 md:inline-block ','classInput'=>'w-full md:w-9/12 float-right'])

    <div class='text-center mt-3 mb-3'>
    <p>Bằng việc đăng ký, bạn đã đồng ý với ThanTai39 về </p>
    <a target='_blank' href="{{SettingHelper::getKey('terms_service_v_privacy_policy')}}"><p class='text-blue-500'>Điều khoản dịch vụ & Chính sách bảo mật</p></a>
    </div>
   

    <button type="submit"  classLabel='hidden md:w-3/12 md:inline-block ' classInput='w-full md:w-9/12 float-right'   class="bg-blue-500 w-full  md:w-24 md:m-auto p-2 text-white rounded-lg " style='display:list-item'>Đăng Ký</button>

    <div class='text-center mt-3' >
        Bạn đã có tài khoản? <a class='text-blue-500' href="{{route('login')}}">Đăng nhập</a>
    </div>

</form>



@endsection
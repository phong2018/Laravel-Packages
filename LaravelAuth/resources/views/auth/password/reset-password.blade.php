@extends(config('laravelauth.layout'))

@section('content')
<h1 class="pagetitle">Tạo mật khẩu mới</h1>
<form action={{ route('password.store')  }} method="post" class='formLogin'>
    @csrf 

    <input type="hidden" name="token" value="{{  $token  }}">
 
    <x-laravelcomponent-forminput  classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'   name="email" value="{{old('email')}}" label="Email" type="text" message="{{($errors->has('email'))?$errors->first('email'):''}}" /> 

    <x-laravelcomponent-forminput  classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'   name="password" value="" label="Mật khẩu" type="password" message="{{($errors->has('password'))?$errors->first('password'):''}}" />

    <x-laravelcomponent-forminput  classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'   name="password_confirmation" value="" label="Nhập lại MK" type="password_confirmation" message="" />

    <button type="submit"  classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'    class="bg-blue-500 w-full  md:w-24 md:m-auto p-2 text-white rounded-lg "style='display:list-item'>Xác nhận</button>

</form>
@endsection
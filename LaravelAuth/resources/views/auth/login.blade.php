@extends(config('laravelauth.layout'))

@section('content')
 
<h1 class="pagetitle">Đăng Nhập</h1>

@if(session('message')) 
    <div class="alert alert-success"><p class='m-0'>{{session('message')}}</p></div>    
@endif

@if(session('error')) 
    <div class="alert alert-danger"><p class='m-0'>{{session('error')}}</p></div>    
@endif

<form action="{{ route('login') }}" method="post" class='formLogin'>
    @csrf 
    <x-laravelcomponent-forminput name="username" value="{{old('username')}}" classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right' label="Số điện thoại" type="text" message="{{($errors->has('username'))?$errors->first('username'):''}}" /> 
 
    <x-laravelcomponent-forminput name="password" value="" classLabel='w-4/12 md:w-3/12'  classInput='w-8/12 md:w-9/12 float-right'  label="Mật khẩu" type="password" message="{{($errors->has('password'))?$errors->first('password'):''}}" />

    <div class="mb-2">
        <div class="items-center">
            <input type="checkbox" name="remember" id="remember" class="mr-2"/>
            <label for="remember">Nhớ mật khẩu</label>

            <a class='float-right text-blue-500 inline-block' href="{{route('password.forgot')}}">Quên mật khẩu! </a> 
        </div>
       
    </div>

    <button type="submit" class="bg-blue-500 w-full  md:w-24 md:m-auto p-2 text-white rounded-lg "style='display:list-item'>Đăng Nhập</button>
 
</form>
 
@endsection
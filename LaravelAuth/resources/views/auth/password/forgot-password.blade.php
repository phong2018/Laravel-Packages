@extends(config('laravelauth.layout'))

@section('content')
<h1 class="pagetitle">Quên Mật Khẩu</h1>

@if(session('message')) 
    <div class="alert alert-success"><p class='m-0'>{{session('message')}}</p></div>    
@endif

@if(session('error')) 
    <div class="alert alert-danger"><p class='m-0'>{{session('error')}}</p></div>    
@endif

<form action={{ route('password.request') }} method="post" class='formLogin'>
    @csrf
    <span class='pb-3 font-bold block'>Nhập Email để nhận Mật khẩu mới!</span>
    <x-laravelcomponent-forminput  classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'   name="email" value="{{old('email')}}" label="Email" type="text" message="{{($errors->has('email'))?$errors->first('email'):''}}" /> 
 
    <button type="submit"  classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'    class="bg-blue-500 w-full  md:w-24 md:m-auto p-2 text-white rounded-lg "style='display:list-item'>Xác Nhận</button>

</form>
@endsection
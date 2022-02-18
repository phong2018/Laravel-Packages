@extends(config('laravelauth.layout'))

@section('content')
<h1 class="pagetitle">Đăng Ký tài khoản</h1>
<form action={{ route('register') }} method="post" class='formLogin'>
    @csrf

    <x-laravelcomponent-forminput   classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'   name="username" value="{{old('username')}}" label="Số điện thoại"  type="text" message="{{($errors->has('username'))?$errors->first('username'):''}}" />

    <x-laravelcomponent-forminput  classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'   name="name" value="{{old('name')}}" label="Họ tên" type="text" message="{{($errors->has('name'))?$errors->first('name'):''}}" />

    <x-laravelcomponent-forminput  classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'   name="email" value="{{old('email')}}" label="Email" type="text" message="{{($errors->has('email'))?$errors->first('email'):''}}" /> 
 
    @include('laravellayout::components.formSelect',['name'=>'role_id','classLabel'=>'w-4/12 md:w-3/12','classInput'=>'w-8/12 md:w-9/12 float-right','label'=>'Loại tài khoản','listItem'=>$roles,'keyValue'=>'id','keyName'=>'name','selectedItem'=>$roles[0]->id,'message'=>($errors->has('role_id'))?$errors->first('role_id'):''])

    <x-laravelcomponent-forminput  classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'   name="password" value="" label="Mật khẩu" type="password" message="{{($errors->has('password'))?$errors->first('password'):''}}" />

    <x-laravelcomponent-forminput  classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'   name="password_confirmation" value="" label="Nhập lại MK" type="password_confirmation" message="" />

    <button type="submit"  classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'   class="bg-blue-500 w-24 p-2 text-white rounded-lg">Đăng Ký</button>

</form>
@endsection
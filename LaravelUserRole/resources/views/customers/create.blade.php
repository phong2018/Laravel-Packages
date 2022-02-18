@extends('laravellayout::layouts.admin')

@section('content')
<div class="md:w-full">
    <h1 class="pagetitle">Create User</h1>
    <form action="{{ route('users.store') }}" method="post">
        @csrf

        <x-laravelcomponent-forminput name="name" value="{{old('name')}}" label="Name" type="text" message="{{($errors->has('name'))?$errors->first('name'):''}}" />

        <x-laravelcomponent-forminput name="username" value="{{old('username')}}" label="Username" type="text" message="{{($errors->has('username'))?$errors->first('username'):''}}" />

        <x-laravelcomponent-forminput name="email" value="{{old('email')}}" label="Email" type="text" message="{{($errors->has('email'))?$errors->first('email'):''}}" /> 

        @include('laravellayout::components.formSelect',['name'=>'role_id','label'=>'Select Role','listItem'=>$roles,'keyValue'=>'id','keyName'=>'name','selectedItem'=>[],'message'=>($errors->has('role_id'))?$errors->first('role_id'):''])

        <x-laravelcomponent-forminput name="password" value="" label="Password" type="password" message="{{($errors->has('password'))?$errors->first('password'):''}}" />

        <x-laravelcomponent-forminput name="password_confirmation" value="" label="Repeat Password" type="password_confirmation" message="" />
        
        <x-laravelcomponent-forminput type="submit" name="" value="" label="Create"  message="" />

    </form>
</div> 
@endsection
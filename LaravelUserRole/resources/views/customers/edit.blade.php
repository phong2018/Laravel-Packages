@extends('laravellayout::layouts.admin') 

@section('content')

<div class="md:w-full">
    <h1 class="pagetitle">Edit Info</h1>
    <form  action="{{ route('customers.update',['customer' => $user]) }}"  method="post">
        @csrf
        @method("PUT")

        <x-laravelcomponent-forminput name="name" value="{{old('name',$user['name'])}}" label="Name" type="text" message="{{($errors->has('name'))?$errors->first('name'):''}}" />

        <x-laravelcomponent-forminput name="username" value="{{old('username',$user['username'])}}" label="Username" type="text" message="{{($errors->has('username'))?$errors->first('username'):''}}" />

        <x-laravelcomponent-forminput name="email" value="{{old('email',$user['email'])}}" label="Email" type="text" message="{{($errors->has('email'))?$errors->first('email'):''}}" /> 

        @include('laravellayout::components.formSelect',['name'=>'role_id','label'=>'Select Role','listItem'=>$roles,'keyValue'=>'id','keyName'=>'name','selectedItem'=>$user['role_id'],'message'=>($errors->has('role_id'))?$errors->first('role_id'):''])

        <x-laravelcomponent-forminput name="password" value="" label="Password" type="password" message="{{($errors->has('password'))?$errors->first('password'):''}}" />

        <x-laravelcomponent-forminput name="password_confirmation" value="" label="Repeat Password" type="password_confirmation" message="" />

        
        @include('laravellayout::components.formSelect',['name'=>'status','label'=>'Status','listItem'=>$status,'keyValue'=>'keyValue','keyName'=>'keyName','selectedItem'=>$user['status'],'message'=>($errors->has('status'))?$errors->first('status'):'','classLabel'=>'w-2/12 md:w-2/12','classInput'=>'w-10/12 md:w-10/12 float-right'])
        
        
        <x-laravelcomponent-forminput type="submit" name="" value="" label="Save"  message="" />
  
    </form>
</div> 
@endsection
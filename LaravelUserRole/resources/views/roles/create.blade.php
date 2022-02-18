@extends('laravellayout::layouts.admin') 

@section('content')
<div class="md:w-full">
    <h1 class="pagetitle">Create Role</h1>
    <form action="{{ route('roles.store') }}" method="post">
        @csrf 
        
        <x-laravelcomponent-forminput name="name" value="{{old('name')}}" label="Role Name" type="text" message="{{($errors->has('name'))?$errors->first('name'):''}}" />  

        @include('laraveluserrole::roles.formInputCheckboxPermission',['permissionsForRole'=>$permissionsForRole,'selectedItem'=>old('permissions')])
        
        <x-laravelcomponent-forminput type="submit" name="" value="" label="Create"  message="" />
    </form>
</div> 
@include('laravellayout::partial.selectAll.selectAll')
@endsection
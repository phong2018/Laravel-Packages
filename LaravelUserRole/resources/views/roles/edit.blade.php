@extends('laravellayout::layouts.admin') 

@section('content')
<div class="md:w-full">
    <h1 class="pagetitle">Edit Role</h1>
    <form action="{{ route('roles.update',['role'=>$role]) }}" method="post">
        @csrf
        @method('PUT')

        <x-laravelcomponent-forminput name="name" value="{{old('name',$role['name'])}}" label="Role Name" type="text" message="{{($errors->has('name'))?$errors->first('name'):''}}" />   

        @include('laraveluserrole::roles.formInputCheckboxPermission',['permissionsForRole'=>$permissionsForRole,'selectedItem'=>old('permissions',json_decode($role['permissions']))])
 

        <div class="mb-2">
            <button type="submit" class="bg-blue-500 border-2 w-full p-2 text-white rounded-lg">Save</button>
        </div>
    </form>
</div> 
@include('laravellayout::partial.selectAll.selectAll')
@endsection
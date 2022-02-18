@extends('laravellayout::layouts.admin')

@section('content')
<div class="md:w-full">
    <h1 class="pagetitle">Create setting</h1>
    <form action="{{ route('settings.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <x-laravelcomponent-forminput name="name" value="{{old('name')}}" label="Setting Name" type="text" message="{{($errors->has('name'))?$errors->first('name'):''}}" />

        @include('laravellayout::components.formSelect',['name'=>'category','label'=>'Select Category','listItem'=>config('laravelsetting.categories'),'keyValue'=>'key','keyName'=>'key','selectedItem'=>'','message'=>($errors->has('category'))?$errors->first('category'):'']) 
 
        <x-laravelcomponent-forminput name="key" value="{{old('key')}}" label="Key" type="text" message="{{($errors->has('key'))?$errors->first('key'):''}}" />

        @include('laravellayout::components.formTextarea',['name'=>'value','value'=>old('value'),'label'=>'Value','message'=>($errors->has('value'))?$errors->first('value'):''])


       
        @include('laravellayout::components.formSelect',['name'=>'serialized','label'=>'Select Serialized','listItem'=>config('laravelsetting.serializedList'),'keyValue'=>'key','keyName'=>'name','selectedItem'=>'','message'=>($errors->has('serialized'))?$errors->first('serialized'):'']) 
     
        <x-laravelcomponent-forminput type="submit" name="" value="" label="Save"  message="" />

    </form>
</div>  
@endsection
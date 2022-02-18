@extends('laravellayout::layouts.admin')

@section('content')
<div class="md:w-full">
    <h1 class="pagetitle">Edit category</h1>
    <form action="{{ route('settings.update',['setting'=>$setting]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
       
        <x-laravelcomponent-forminput name="name" value="{{old('name',$setting['name'])}}" label="Setting Name" type="text" message="{{($errors->has('name'))?$errors->first('name'):''}}" />

        @include('laravellayout::components.formSelect',['name'=>'category','label'=>'Select Category','listItem'=>config('laravelsetting.categories'),'keyValue'=>'key','keyName'=>'key','selectedItem'=>$setting['category'],'message'=>($errors->has('category'))?$errors->first('category'):'']) 
 
        <x-laravelcomponent-forminput name="key" value="{{old('key',$setting['key'])}}" label="Key" type="label" message="{{($errors->has('key'))?$errors->first('key'):''}}" /> 
        
        @include('laravellayout::components.formTextarea',['name'=>'value','value'=>old('value',$setting['value']),'label'=>'Value','message'=>($errors->has('value'))?$errors->first('value'):''])

       
        @include('laravellayout::components.formSelect',['name'=>'serialized','label'=>'Select Serialized','listItem'=>config('laravelsetting.serializedList'),'keyValue'=>'key','keyName'=>'name','selectedItem'=>$setting['serialized'],'message'=>($errors->has('serialized'))?$errors->first('serialized'):'']) 
     
        <x-laravelcomponent-forminput type="submit" name="" value="" label="Save"  message="" />
    </form>
</div> 
@endsection


 
@extends('laravellayout::layouts.admin')

@section('content')
<div class="md:w-full">
    <h1 class="text-2xl pb-3">Edit category</h1>
    <form action="{{ route('categories.update',['category'=>$category]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
       
        <x-laravelcomponent-forminput name="name" value="{{old('name',$category['name'])}}" label="Category Name" type="text" message="{{($errors->has('name'))?$errors->first('name'):''}}" /> 

        @include('laravellayout::components.formTextarea',['name'=>'description','value'=>old('description',$category['description']),'label'=>'Category description','message'=>($errors->has('description'))?$errors->first('description'):''])

        <x-laravelcomponent-forminput type="submit" name="" value="" label="Save"  message="" />
    </form>
</div> 
@endsection
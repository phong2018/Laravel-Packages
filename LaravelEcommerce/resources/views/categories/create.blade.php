@extends('laravellayout::layouts.admin')

@section('content')
<div class="md:w-full">
    <h1 class="text-2xl pb-3">Create category</h1>
    <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <x-laravelcomponent-forminput name="name" value="{{old('name')}}" label="Category Name" type="text" message="{{($errors->has('name'))?$errors->first('name'):''}}" />

        @include('laravellayout::components.formTextarea',['name'=>'description','value'=>old('description'),'label'=>'Category description','message'=>($errors->has('description'))?$errors->first('description'):''])

        <x-laravelcomponent-forminput type="submit" name="" value="" label="Save"  message="" />

    </form>
</div>  
@endsection
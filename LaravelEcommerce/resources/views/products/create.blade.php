@extends('laravellayout::layouts.admin')
@section('content')
<!-- use for upload image in ckEditor -->
@include('laravellayout::partial.editor.CkEditor')
<!-- use for udload image by alone button -->
<script>{!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/stand-alone-button.js')) !!}</script>

<div class="md:w-full">
    <h1 class="text-2xl pb-3">Create product</h1>
    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        
        <x-laravelcomponent-forminput name="name" value="{{old('name')}}" label="Product Name" type="text" message="{{($errors->has('name'))?$errors->first('name'):''}}" />

        @include('laravellayout::components.formTextareaCkEditor',['name'=>'description','value'=>old('description'),'label'=>'Product description','message'=>($errors->has('description'))?$errors->first('description'):''])

        <x-laravelcomponent-forminput type="number" name="price" value="{{old('price')}}" label="Product price"  message="{{($errors->has('price'))?$errors->first('price'):''}}" />

        @include('laravellayout::components.formImageFileManager',['name'=>'image','label'=>'image','value'=>old('image'),'message'=>''])
        
        @include('laravellayout::components.formCheckbox',['name'=>'categories[]','label'=>'Categories','listItem'=>$categories,'keyValue'=>'id','keyName'=>'name','selectedItem'=>old('categories')]) 
 
        <x-laravelcomponent-forminput type="submit" name="" value="" label="Save"  message="" />
    </form> 
</div>  

@include('laravellayout::partial.selectAll.selectAll')
@endsection
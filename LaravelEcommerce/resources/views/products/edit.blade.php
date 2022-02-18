@extends('laravellayout::layouts.admin')

@section('content')
<!-- use for upload image in ckEditor -->
@include('laravellayout::partial.editor.CkEditor')
<!-- use for udload image by alone button -->
<script>{!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/stand-alone-button.js')) !!}</script> 

<div class="md:w-full">
    <h1 class="text-2xl pb-3">Edit product</h1>
    <form action="{{ route('products.update',['product'=>$product]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <x-laravelcomponent-forminput name="name" value="{{old('name',$product['name'])}}" label="Product Name" type="text" message="{{($errors->has('name'))?$errors->first('name'):''}}" /> 
            
        @include('laravellayout::components.formTextareaCkEditor',['name'=>'description','value'=>old('description',$product['description']),'label'=>'Product description','message'=>($errors->has('description'))?$errors->first('description'):''])
 

        <x-laravelcomponent-forminput type="number" name="price" value="{{old('price',$product['price'])}}" label="Product price"  message="{{($errors->has('price'))?$errors->first('price'):''}}" />

        @include('laravellayout::components.formImageFileManager',['name'=>'image','label'=>'image','value'=>old('image',$product['image']),'message'=>($errors->has('image'))?$errors->first('image'):''])

        @include('laravellayout::components.formCheckbox',['name'=>'categories[]','label'=>'Categories','listItem'=>$categories,'keyValue'=>'id','keyName'=>'name','selectedItem'=>old('categories',Arr::pluck($product->categories,'id'))])

        

        <x-laravelcomponent-forminput type="submit" name="" value="" label="Save"  message="" />

    </form>
</div> 
@include('laravellayout::partial.selectAll.selectAll',['checkboxName'=>'categories'])
@endsection
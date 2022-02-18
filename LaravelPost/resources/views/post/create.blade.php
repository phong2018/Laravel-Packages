@extends('laravellayout::layouts.admin')
@section('content')
<!-- use for upload image in ckEditor -->
@include('laravellayout::partial.editor.CkEditor')
<!-- use for udload image by alone button -->
<script>{!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/stand-alone-button.js')) !!}</script>

<div class="md:w-full">
    <h1 class="text-2xl pb-3">Create Post</h1>
    <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        
        <x-laravelcomponent-forminput name="title" value="{{old('title')}}" label="Title" type="text" message="{{($errors->has('title'))?$errors->first('title'):''}}" />
        <x-laravelcomponent-forminput name="description" value="{{old('description')}}" label="Description" type="text" message="{{($errors->has('description'))?$errors->first('description'):''}}" />

        @include('laravellayout::components.formTextareaCkEditor',['name'=>'content','value'=>old('content'),'label'=>'Content','message'=>($errors->has('content'))?$errors->first('content'):'']) 

        <x-laravelcomponent-forminput name="publish_date" value="{{old('publish_date',date('Y-m-d'))}}" label="Publish date" type="date" message="{{($errors->has('publish_date'))?$errors->first('publish_date'):''}}" />
        
        @include('laravellayout::components.formSelect',['name'=>'status','label'=>'Status','listItem'=>$data['status'],'keyValue'=>'keyValue','keyName'=>'keyName','selectedItem'=>1,'message'=>($errors->has('status'))?$errors->first('status'):''])

        
        <x-laravelcomponent-forminput name="sort_order" value="{{old('sort_order')}}" label="Sort Order" type="number" message="{{($errors->has('sort_order'))?$errors->first('sort_order'):''}}" />

        @include('laravellayout::components.formImageFileManager',['name'=>'image','label'=>'image','value'=>old('image'),'message'=>''])

        @include('laravellayout::components.formCheckbox',['name'=>'threads[]','label'=>'threads','listItem'=>$data['threads'],'keyValue'=>'id','keyName'=>'title','selectedItem'=>old('threads')]) 
 
        <x-laravelcomponent-forminput type="submit" name="" value="" label="Save"  message="" />
    </form> 
</div>  

@include('laravellayout::partial.selectAll.selectAll')
@endsection
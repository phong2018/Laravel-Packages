@extends('laravellayout::layouts.admin')
@section('content')
<!-- use for upload image in ckEditor -->
@include('laravellayout::partial.editor.CkEditor')
<!-- use for udload image by alone button -->
<script>{!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/stand-alone-button.js')) !!}</script>

<div class="md:w-full">
    <h1 class="text-2xl pb-3">Create thread</h1>
    <form action="{{ route('thread.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        
        <x-laravelcomponent-forminput name="title" value="{{old('title')}}" label="Title" type="text" message="{{($errors->has('title'))?$errors->first('title'):''}}" />

        @include('laravellayout::components.formTextareaCkEditor',['name'=>'description','value'=>old('description'),'label'=>'description','message'=>($errors->has('description'))?$errors->first('description'):'']) 

        <x-laravelcomponent-forminput name="sort_order" value="{{old('sort_order')}}" label="Sort Order" type="number" message="{{($errors->has('sort_order'))?$errors->first('sort_order'):''}}" />

        @include('laravellayout::components.formSelect',['name'=>'parent_id','label'=>'Parent','listItem'=>$data['threads'],'keyValue'=>'id','keyName'=>'title','selectedItem'=>0,'message'=>($errors->has('parent_id'))?$errors->first('parent_id'):''])

        @include('laravellayout::components.formSelect',['name'=>'status','label'=>'Status','listItem'=>$data['status'],'keyValue'=>'keyValue','keyName'=>'keyName','selectedItem'=>1,'message'=>($errors->has('status'))?$errors->first('status'):''])

   
 
        <x-laravelcomponent-forminput type="submit" name="" value="" label="Save"  message="" />
    </form> 
</div>  

@include('laravellayout::partial.selectAll.selectAll')
@endsection
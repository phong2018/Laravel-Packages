
<?php
use Phonglg\LaravelVeso\Helpers\ImageHelper;
?>
@extends('laravellayout::layouts.admin')

@section('title', $data['title'])

@section('content') 
    <div class="w-full">
        <h1 class="pagetitle">Danh Sách Post</h1>
        <div>
            <a href={{route('post.create')}} class="btn btn-primary float-rights text-white mb-2">
            Tạo Post 
            </a>   
            <div class='overflow-hidden w-full '>
            @include('laravelpost::post.components.formSearch',['formUrl'=>route('post.index')]) 
            </div>
        </div> 
        
        
    </div>

    @if(session('message')) 
        <div class="alert alert-success"><p class='m-0'>{{session('message')}}</p></div>    
    @endif

    @if(session('error')) 
        <div class="alert alert-danger"><p class='m-0'>{{session('error')}}</p></div>    
    @endif
 

    @if($data['posts']->count()>0)
    <div class="overflow-x-scroll  ">
        <table class="table">
            <tr class="listTable">
                <th>#</th>
                <th class="text-center">Chức năng</th>
                <th>Image</th>
                <th>Title</th> 
                <th>Description</th> 
                <th>Publish date</th> 
                <th>Status</th>  
                
            </tr>  
            @foreach($data['posts'] as $no=>$post)
            <tr>
                <!-- Form quick Edit  -->
                <td>{{ $no+1}}</td>
                <!-- End Form quick Edit  -->
                <td class='text-center'>
                    <table class='text-center w-full' ><td>
                    @can('update',$post)
                        <a title='Sửa' href="{{route('post.edit',['post'=>$post])}}" class="p-1">
                        <i class="far fa-edit"></i>
                        </a>
                    @endcan 
                    </td><td>
                    <form title='Sao chép' class="inline" method="POST"  action="{{route('post.copy',['post'=>$post])}}">
                        @csrf 
                        <button type="submit" class="p-1"> <i class="far fa-copy" ></i></button>
                    </form>  
                    </td><td>
                    @can('delete',$post)
                    <form title='Xóa' class="inline" id="formDelete{{$post['id']}}" method="POST"  action="{{route('post.destroy',['post'=>$post])}}">
                        @csrf
                        @method("DELETE")
                        <button type="submit" onClick="confirmFormSubmit('formDelete{{$post['id']}}')" class="p-1">
                        <i class="far fa-trash-alt"  ></i>
                        </button>
                    </form> 
                    @endcan  
                    </td></table>
                </td>
                <td>
                @if($post->image)                    
                <img src="{{asset(  ImageHelper::showThumbImg($post->image) )}}" class='w-10 mt-1' alt=""/>
                @endif
                </td>  
                <td>
                    <a target='_blank' class='text-blue-500' href="{{route('post.showSlug',['slug'=>$post->slug])}}">{{$post->title}}</a>
                </td>
                <td>{{$post->description}}</td>
                <td>{{date("d/m/Y", strtotime($post->publish_date))}} </td>
                <td>{{$post->status}}</td>  
            </tr>
            @endforeach
        </table>  
        {{ $data['posts']->links() }}
    </div>
    @endif
    @include('laravellayout::partial.popup.formConfirm') 
@endsection

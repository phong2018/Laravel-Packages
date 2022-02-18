
<?php
use Phonglg\LaravelVeso\Helpers\ImageHelper;
?>
@extends('laravellayout::layouts.admin')

@section('title', $data['title'])

@section('content') 
    <div class="w-full">
        <h1 class="pagetitle">Danh Sách thread</h1>
        <div>
            <a href={{route('thread.create')}} class="btn btn-primary float-rights text-white mb-2">
            Tạo thread 
            </a>   
            <div class='overflow-hidden w-full '>
            @include('laravelpost::post.components.formSearch',['formUrl'=>route('thread.index')]) 
            </div>
        </div>
    </div>

    @if(session('message')) 
        <div class="alert alert-success"><p class='m-0'>{{session('message')}}</p></div>    
    @endif

    @if(session('error')) 
        <div class="alert alert-danger"><p class='m-0'>{{session('error')}}</p></div>    
    @endif


    @if($data['threads']->count()>0)
    <div class="overflow-x-scroll  ">
        <table class="table">
            <tr class="listTable">
                <th>#</th>
                <th class="text-center">Chức năng</th>
                <th>Title</th> 
                <th>Publish date</th> 
                <th>Status</th>  
                
            </tr>  
            @foreach($data['threads'] as $no=>$thread)
            <tr>
                <!-- Form quick Edit  -->
                <td>{{ $no+1}}</td>
                <!-- End Form quick Edit  -->
                <td class='text-center'>
                    <table class='text-center w-full' ><td>
                    @can('update',$thread)
                        <a title='Sửa' href="{{route('thread.edit',['thread'=>$thread])}}" class="p-1">
                        <i class="far fa-edit"></i>
                        </a>
                    @endcan 
                    </td><td>
                    <form title='Sao chép' class="inline" method="post"  action="{{route('thread.copy',['thread'=>$thread])}}">
                        @csrf 
                        <button type="submit" class="p-1"> <i class="far fa-copy" ></i></button>
                    </form>  
                    </td><td>
                    @can('delete',$thread)
                    <form title='Xóa' class="inline" id="formDelete{{$thread['id']}}" method="post"  action="{{route('thread.destroy',['thread'=>$thread])}}">
                        @csrf
                        @method("DELETE")
                        <button type="submit" onClick="confirmFormSubmit('formDelete{{$thread['id']}}')" class="p-1">
                        <i class="far fa-trash-alt"  ></i>
                        </button>
                    </form> 
                    @endcan  
                    </td></table>
                </td> 
                <td>
                    <a target='_blank' class='text-blue-500' href="{{route('thread.showSlug',['slug'=>$thread->slug])}}">{{$thread->title}}</a>
                </td>
                <td>{{date("d/m/Y", strtotime($thread->publish_date))}} </td>
                <td>{{$thread->status}}</td>  
            </tr>
            @endforeach
        </table>  
        {{ $data['threads']->links() }}
    </div>
    @endif
    @include('laravellayout::partial.popup.formConfirm') 
@endsection

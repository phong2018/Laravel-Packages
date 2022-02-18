@extends('laravellayout::layouts.admin')

@section('content')
    {{-- {{dd($categories)}} --}}
    <div class="overflow-hidden mb-3">
        <h1 class="text-2xl pb-3 inline">List category</h1>
        <a href={{route('categories.create')}} class="btn btn-primary">Create category</a>
    </div>

    @if(session('message')) 
        <div class="alert alert-success"><p class='m-0'>{{session('message')}}</p></div>    
    @endif

    @if($categories->count()>0)
    <div class="overflow-x-scroll">
        <table class="table">
            <tr> 
                <th>Name</th>
                <th>Description</th>  
                <th class="text-center">Action</th>
            </tr>
            @foreach($categories as $category)
            <tr> 
                <td>{{$category['name']}}</td>
                <td>{{$category['description']}}</td> 
                <td class='text-center'>
                    <a href="{{route('categories.edit',['category'=>$category])}}" class="btn btn-success">Edit</a>
                    
                    <form class="inline" id="form{{$category['id']}}" method="POST"  action="{{route('categories.destroy',['category'=>$category])}}">
                        @csrf
                        @method("DELETE")
                        <button type="submit" onClick="confirmFormSubmit('form{{$category['id']}}')" class="btn btn-danger">Delete</button>
                    </form> 
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    @endif
    @include('laravellayout::partial.popup.formConfirm')
@endsection
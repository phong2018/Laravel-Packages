@extends('laravellayout::layouts.admin') 

@section('content')
    {{-- {{dd($roles)}} --}}
    <div class="overflow-hidden mb-3">
        <h1 class="pagetitle inline">List role</h1>
        <a href={{route('roles.create')}} class="btn btn-primary">Create role</a>
    </div>

    @if(session('message')) 
        <div class="alert alert-success"><p class='m-0'>{{session('message')}}</p></div>    
    @endif

    @if($roles->count()>0)
    <div class="overflow-x-scroll">
        <table class="table">
            <tr>
                <th>Name</th>
                <th>Slug</th> 
                <th class="text-center">Action</th>
            </tr>
            @foreach($roles as $role)
            <tr>
                <td>{{$role['name']}}</td>
                <td>{{$role['slug']}}</td> 
                <td class='text-center'>
                    <a href="{{route('roles.edit',['role'=>$role])}}" class="btn btn-success">Edit</a>
                    @can('delete',$role)
                    <form class="inline" id="form{{$role['id']}}" method="POST"  action="{{route('roles.destroy',['role'=>$role])}}">
                        @csrf
                        @method("DELETE")
                        <button type="submit" onClick="confirmFormSubmit('form{{$role['id']}}')" class="btn btn-danger">Delete</button>
                    </form> 
                    @endcan
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    @endif
    @include('laravellayout::partial.popup.formConfirm')

@endsection
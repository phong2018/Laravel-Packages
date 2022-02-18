@extends('laravellayout::layouts.admin') 

@section('content')
 
    {{-- {{dd($users)}} --}}
    <div class="overflow-hidden mb-3">
        <h1 class="pagetitle inline">Danh sách Khách hàng</h1>
        <a href={{route('customers.create')}} class="btn btn-primary">Tạo Mới</a>
    </div>

    @if(session('message'))
        <div class="alert alert-success"><p class='m-0'>{{session('message')}}</p></div>    
    @endif

    @if($users->count()>0)
    <div class="overflow-x-scroll">
        <table class="table">
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th class="text-center">Action</th>
            </tr>
            @foreach($users as $user)
            <tr>
                <td>
                    <a href="{{route('customers.customerLog',['customer'=>$user])}}" target='_blank'>
                    {{$user['name']}}
                    </a>
                </td>
                <td>{{$user['username']}}</td>
                <td>{{$user['email']}}</td>
                <td>{{$user->role->name}}</td>
                <td class='text-center'>
                    @can('update',$user)
                    <a href="{{route('customers.edit',['customer'=>$user])}}" class="btn btn-success">Edit</a>
                    @endcan

                    @can('delete',$user)
                    <form class="inline" id="form{{$user['id']}}" method="POST"  action="{{route('customers.destroy',['customer'=>$user])}}">
                        @csrf
                        @method("DELETE")
                        <button type="submit" onClick="confirmFormSubmit('form{{$user['id']}}')" class="btn btn-danger">Delete</button>
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
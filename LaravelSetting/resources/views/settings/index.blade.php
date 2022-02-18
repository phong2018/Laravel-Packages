@extends('laravellayout::layouts.admin')

@section('content')
    {{-- {{dd($settings)}} --}}
    <div class="overflow-hidden mb-3">
        <h1 class="pagetitle inline">List setting</h1>
        <a href={{route('settings.create')}} class="btn btn-primary">Create setting</a>
        <a href={{route('settings.resetPointCustomer')}} class="btn btn-danger">Reset Point Info</a>
    </div>

    @if(session('message')) 
        <div class="alert alert-success"><p class='m-0'>{{session('message')}}</p></div>    
    @endif

    @if($settings->count()>0)
    <div class="overflow-x-scroll">
        <table class="table">
            <tr> 
                <th>Name</th>
                <th>Category</th>  
                <th>Key</th>  
                <th>Value</th>  
                <th>Serialized</th>  
                <th class="text-center">Action</th>
            </tr>
            @foreach($settings as $setting)
            <tr> 
                <td>{{$setting['name']}}</td>
                <td>{{$setting['category']}}</td> 
                <td>{{$setting['key']}}</td> 
                <td>{{$setting['value']}}</td> 
                <td>{{$setting['serialized']}}</td> 
                <td class='text-center'>
                    <a href="{{route('settings.edit',['setting'=>$setting])}}" class="btn btn-success">Edit</a>
                    
                    <form class="inline" id="form{{$setting['id']}}" method="POST"  action="{{route('settings.destroy',['setting'=>$setting])}}">
                        @csrf
                        @method("DELETE")
                        <button type="submit" onClick="confirmFormSubmit('form{{$setting['id']}}')" class="btn btn-danger">Delete</button>
                    </form> 
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    @endif
    @include('laravellayout::partial.popup.formConfirm')
@endsection
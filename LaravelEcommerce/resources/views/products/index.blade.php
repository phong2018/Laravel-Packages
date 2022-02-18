@extends('laravellayout::layouts.admin')

@section('content')
    {{-- {{dd($products)}} --}}
    <div class="overflow-hidden mb-3">
        <h1 class="text-2xl pb-3 inline">List product</h1>
        <a href={{route('products.create')}} class="btn btn-primary">Create product</a>
    </div>

    @if(session('message')) 
        <div class="alert alert-success"><p class='m-0'>{{session('message')}}</p></div>    
    @endif

    @if($products->count()>0)
    <div class="overflow-x-scroll">
        <table class="table">
            <tr>
                <th>Image</th>
                <th>Name</th> 
                <th>Price</th> 
                <th class="text-center">Action</th>
            </tr> 
            
            @foreach($products as $product)
            <tr>
                <td>
                    <img src="{{asset($product['image'])}}" class='w-20' alt=""/>
                </td>
                <td>{{$product['name']}}</td> 
                <td>{{$product['price']}}</td> 
                <td class='text-center'>
 
                    @can('update',$product)
                        <a href="{{route('products.edit',['product'=>$product])}}" class="btn btn-success">Edit</a>
                    @endcan

                    @can('delete',$product)
                    <form class="inline" id="form{{$product['id']}}" method="POST"  action="{{route('products.destroy',['product'=>$product])}}">
                        @csrf
                        @method("DELETE")
                        <button type="submit" onClick="confirmFormSubmit('form{{$product['id']}}')" class="btn btn-danger">Delete</button>
                    </form> 
                    @endcan  
                </td>
            </tr>
            @endforeach
        </table>
        {{ $products->links() }}
    </div>
    @endif
    @include('laravellayout::partial.popup.formConfirm')
@endsection
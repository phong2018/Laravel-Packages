@extends('laravellayout::layouts.shop')

@section('content')
<div class="container px-6 mx-auto">
     <h3 class="text-2xl font-medium text-gray-700">Cart List</h3>
     <a href="{{route('order.checkout')}}" class="">Checkout</a>
     
     @if(session('message'))
          <div class="alert alert-success">
               <p class="m-0">{{session('message')}}</p>
          </div>
     @endif

     @include('laravelecommerce::component.cart',['cart'=>$cart])
</div>
@endsection
@extends('laravellayout::layouts.shop')

@section('content')
<div class="container px-6 mx-auto">
     <h3 class="text-2xl font-medium text-gray-700">Checkout</h3>
     @if(session('message'))
          <div class="alert alert-success">
               <p class="m-0">{{session('message')}}</p>
          </div>
     @endif

     <div class="flex sm:flex-col md:flex-row ">
        <div class="w-full sm:w-full md:w-6/12">
            @include('laravelecommerce::component.cart',['cart'=>$cart])
        </div>
        <div class="sm:w-full md:w-6/12"> 
            @include('laravelecommerce::component.customerInfo')
        </div>
        
    </div> 
    
</div>
@endsection
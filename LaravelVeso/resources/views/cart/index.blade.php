@extends(config('laravelveso.layout'))

@section('content')
<div class="mx-auto">
     <h1 class="pagetitle">Giỏ Hàng </h1>
     
     @if(session('message'))
          <div class="alert alert-success">
               <p class="m-0">{{session('message')}}</p>
          </div>
     @endif

     @include('laravelveso::component.cartItems')
     <div class='overflow-hidden w-full'><a href="{{route('cart.checkout')}}" class="btn btn-danger w-full  md:w-44 md:m-auto p-2 text-white rounded-lg "style='display:list-item'>Thanh toán</a></div> 

</div>
@include('laravelveso::component.scriptUpdateQtyCart')
@endsection
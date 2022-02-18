@extends(config('laravelveso.layout'))

@section('content')
<div class="mx-auto">
     <h1 class="pagetitle">Thanh Toán </h1>
     @if(session('message'))
          <div class="alert alert-success">
               <p class="m-0">{{session('message')}}</p>
          </div>
     @endif

     <div class="bg-white md:bg-white ">
        <div class="w-full md:w-full">
            @include('laravelveso::component.cartItems')
        </div>

        <div class="w-full  md:w-full mb-7"> 
            @if(!isset($data['customer']))               
                <div><a class='btn-cart bg-blue-400 ' href="{{route('login')}}">Đăng Nhập</a>&nbsp hoặc<a  class="btn-cart bg-red-400" href="{{route('register')}}">Đăng Ký</a>&nbsp để mua vé số. </div>
            @else 
                @include('laravelveso::component.paymentInfo')
            @endif
        </div>
    </div> 
</div>
@include('laravellayout::script.scriptCommasNumber') 
@include('laravelveso::component.scriptUpdateQtyCart') 
@endsection
 
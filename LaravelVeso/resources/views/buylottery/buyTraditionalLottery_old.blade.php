
<?php
use Phonglg\LaravelVeso\Helpers\ImageHelper;
?>

@extends(config('laravelveso.layout'))

@section('content')
<div class="mx-auto overflow-hidden">
     <h1 class="pagetitle">Mua vé số truyền thống</h1> 
     @include('laravelveso::component.formSearchTraditionalTicket',['numFilter'=>$numFilter]) 
     
     @if(session('message'))
          <div class="alert alert-success">
               <p class="m-0">
                    {{session('message')}}
                     Xem <a class='text-blue-500' href="{{route('cart.index')}}">Giỏ Hàng</a>

               </p>

          </div>
     @endif

     

     <div class="w-full">
          @foreach ($products as $product)

          <!-- cart item -->
          <div class="w-1/2 md:w-1/3 float-left p-1 pl-0 pr-0">
               <div class='thumbProductVeso'> 

                    <img src="{{asset(  ImageHelper::showThumbImg($product['image']) )}}" class='w-full max-h-60' alt=""/>
                    
                    <div class="flex items-end justify-end w-full bg-cover">
                    </div>

                    <div class="px-1 py-1 text-center">
                         <h3 class="text-red-400 uppercase float-left text-lg font-bold inline-block mb-0">{{ $product->number }}</h3> 
                         <p class='inline-block float-right pt-1'>
                         @if(isset($provinces[$product->province]))
                              {{$provinces[$product->province]}} 
                         @endif
                         </p>
                         <div class='w-full ticketInfo overflow-hidden pb-1'>
                              <span class="text-gray-500 float-left inline-block">{{ number_format($product->price) }}Đ</span>
                              
                              <span class="text-gray-500 float-right inline-block"><i class="far fa-calendar-alt"></i> {{ date("d/m/Y", strtotime( $product->prize_date ))}}</span>
                         </div>  
                         
                         <form class='inline-block w-full' action="{{ route('cart.store',['product'=>$product]) }}" method="POST" enctype="multipart/form-data">
                                   @csrf
                                   <input type="hidden" value="{{ $product->id }}" name="id">
                                   <input type="hidden" value="{{ $product->name }}" name="name">
                                   <input type="hidden" value="{{ $product->price }}" name="price">
                                   <input type="hidden" value="{{ $product->image }}"  name="image">
                                   <input type="hidden" value="1" name="quantity">
                                   <button class="px-4 text-white bg-blue-800 rounded w-full">
                                   <i class="fas fa-cart-plus"></i>
                                   </button>
                              </form>
                         
                         

                         @if($cart->where('id',$product->id)->count())
                              <span class="border bg-green-400 p-2 hidden">in Cart</span>
                         @endif
                         
                    </div>
               </div> 
               
          </div>
          @endforeach
          {{ $products->links() }}
     </div>
</div>
@endsection
 
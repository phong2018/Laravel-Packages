@extends(config('laravelveso.layoutAdmin'))

@section('content')
<div class="mx-auto">
     <h1 class="pagetitle">Thông tin vé mua</h1> 
     
     @if(session('message'))
          <div class="alert alert-success">
               <p class="m-0">{{session('message')}}</p>
          </div>
     @endif

     @include('laravelveso::adminOrder.showItems')
</div>
@endsection
 
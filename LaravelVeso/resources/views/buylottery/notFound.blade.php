@extends(config('laravelveso.layout'))

@section('content')
<div class="mx-auto"> 
     
     @if(session('message'))
          <div class="alert alert-success">
               <p class="m-0">{{session('message')}}</p>
          </div>
     @endif
     @if(session('error'))
          <div class="alert alert-danger">
               <p class="m-0 text-xl">{{session('error')}}</p>
          </div>
     @endif
 
</div>
@endsection
 
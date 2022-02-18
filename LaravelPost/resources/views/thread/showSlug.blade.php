
@extends(config('laravelpost.homeLayout'))

@section('content')
<div class="mx-auto">
     <h1 class="pagetitle">{{$thread->title}}</h1>   
     <div class="bg-white md:bg-white ">
     {!!$thread->description!!} 
     @include('laravelpost::post.components.listPost',['posts'=>$data['posts']]) 
     
    </div> 
</div> 
@endsection
 
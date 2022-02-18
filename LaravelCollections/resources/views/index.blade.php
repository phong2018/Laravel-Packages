@extends('laravellayout::layouts.home')

@section('content')
<div class="container px-6 mx-auto">
     <div class="row pt-3">
         <h1 class="h1">Post</h1>
     </div>
     @foreach($posts as $post)
     <div class="row pb3">
         <div class="p2 border rounded">
           <a href="{{$post['data']['url']}}" class="d-block font-weight-bold">
            {{$post['data']['title']}}
           </a>  
         </div>
     </div>
     @endforeach
</div>
@endsection
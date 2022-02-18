@extends('laravellayout::layouts.home')

@section('content')
<div class="container px-6 mx-auto">
     <div class="row pt-3">
         <h1 class="h1">Post First</h1>
     </div>  
     <div class="row pb3">
         <div class="p2 border rounded d-flex">
           <img src="{{$post['data']['thumbnail']}}" alt="" class="d-block mr-3">
           <a href="{{$post['data']['url']}}" class="d-block font-weight-bold">
           {{$post['data']['ups']}} - {{$post['data']['title']}}
           </a>  
         </div>
     </div> 
</div>
@endsection
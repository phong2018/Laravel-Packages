@extends('laravellayout::layouts.home')

@section('content')
<div class="container px-6 mx-auto">
     <div class="row pt-3">
         <h1 class="h1">Post Chunk</h1>
     </div>
     @foreach($posts as $chunk)
     <div class="row pb3">
         @foreach($chunk as $post)
          <div class="col-6 p2 mt-3 border rounded ">
            <a href="{{$post['data']['url']}}" class="d-block font-weight-bold">
              {{$post['data']['title']}}
            </a>  
          </div>
         @endforeach
     </div>
     @endforeach
</div>
@endsection
@extends(config('laravelpost.homeLayout'))

@section('title', $data['title'])

@section('content')
<div class="mx-auto">
   <h1 class="pagetitle">Tìm kiếm</h1>  
     @include('laravelpost::post.components.listPost',['posts'=>$data['posts']]) 
</div> 
@endsection
 
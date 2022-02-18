@extends(config('laravelpost.homeLayout'))

@section('content')
<div class="mx-auto">
     <h1 class="pagetitle">{{$post->title}}</h1>  
     <p class='mb-2 italic'>
         <i class="far fa-calendar-alt"></i>  {{date("d/m/Y", strtotime($post->publish_date))}}  &nbsp 
         <i class="far fa-folder"></i>
         @if($data['thread'])
         <a target='_blank' class='text-blue-500' href="{{route('thread.showSlug',['slug'=>$data['thread']->slug])}}">{{$data['thread']->title}}</a>
         @endif
    </p>
     <h3 class="font-bold pb-2 italic">{{$post->description}}</h3>  
     <div class="bg-white md:bg-white ">
     {!!$post->content!!}
     <h2 class='pageSubTitle mt-3 mb-2' >Bài viết cùng chủ đề</h2>
     @include('laravelpost::post.components.listPost',['posts'=>$data['relatedPosts']]) 
    </div> 
</div> 
@endsection
 
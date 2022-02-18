
<?php
use Phonglg\LaravelVeso\Helpers\ImageHelper;
?>
<div class='mb-3'>
@foreach($posts as $post)
<table>
    <td class='w-12'>@if($post->image)                    
    <img src="{{asset(  ImageHelper::showThumbImg($post->image) )}}" class='w-10 mt-1' alt=""/>
    @endif</td>
    <td><p><a href="{{route('post.showSlug',['slug'=>$post->slug])}}">{{$post->title}}</a></p></td>
</table> 
@endforeach
</div>
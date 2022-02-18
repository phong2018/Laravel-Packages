<h2 class="h2">Image Post</h2>
@foreach($children as $post)
<div class="col-12">
    <img src="{{$post['data']['url']}}" alt="" class="mw-100">
</div>
@endforeach
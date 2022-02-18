<h2 class="h2">Self Post</h2>
@foreach($children as $post)
<div class="col-12">
    <p>{!! html_entity_decode($post['data']['selftext_html']) !!}</p>
</div>
@endforeach
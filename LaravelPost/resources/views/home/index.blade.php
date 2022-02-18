@extends(config('laravelpost.homeLayout'))

@section('content')
<div class="mx-auto">
   {!!$data['post']->content!!}
</div> 
@endsection
 
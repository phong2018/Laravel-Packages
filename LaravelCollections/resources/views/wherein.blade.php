@extends('laravellayout::layouts.home')

@section('content')
<div class="container px-6 mx-auto">
     <div class="row pt-3">
         <h1 class="h1">Group Posts via WhereIn</h1>
     </div>
     @foreach($posts as $type=>$children)
        @include('laravelcollections::groupby.'.$type)
     @endforeach
</div>
@endsection
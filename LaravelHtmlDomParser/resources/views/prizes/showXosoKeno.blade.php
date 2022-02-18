@extends('laravellayout::template.xoso.home')
 
@section('content')
<div class="md:w-full">
    <h1 class="pagetitle">Kết Quả xổ số Keno</h1>

     @foreach($prizes as $prize)
        @include('laravelhtmldomparser::prizes.component.keno',['prize'=>$prize]) 
     @endforeach 

     @include('laravelhtmldomparser::prizes.component.showPreviousPrizeVietlottKeno')
</div>  
@endsection
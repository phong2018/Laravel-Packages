@extends('laravellayout::template.xoso.home')
 
@section('content')
@include('laravelhtmldomparser::prizes.component.styles.mienbac') 
<div class="md:w-full"> 
    <h1 class="pagetitle">Kết quả sổ xố Miền Bắc</h1>
    @include('laravelhtmldomparser::prizes.component.showPreviousPrizeTraditional')
    <div id="liveResultLottery">
        @if(count($prizesResult[0])>0)
            @include('laravelhtmldomparser::prizes.component.mienbac',['prizes'=>$prizesResult[0]]) 
        @endif
    </div> 
    @for($i=1;$i<count($prizesResult);$i++)
        @if(count($prizesResult[$i])>0)
            @include('laravelhtmldomparser::prizes.component.mienbac',['prizes'=>$prizesResult[$i]]) 
        @endif
    @endfor
</div>  

@include('laravelhtmldomparser::prizes.component.scriptAxiosResult') 
@if($data['checkGetLatestPrize'])
    <script>
        axiosResultLottery("{{$categoryType}}",0);
        setInterval(function(){ 
            axiosResultLottery("{{$categoryType}}",0);
        }, 5000);
    </script>
@endif
@endsection
 
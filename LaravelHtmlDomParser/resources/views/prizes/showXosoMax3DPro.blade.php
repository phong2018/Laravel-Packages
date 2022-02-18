@extends('laravellayout::template.xoso.home')
 
@section('content')
@include('laravelhtmldomparser::prizes.component.styles.max3dpro') 
<div class="md:w-full">
    <h1 class="pagetitle">Kết Quả xổ số Max3D Pro </h1>
    @include('laravelhtmldomparser::prizes.component.showPreviousPrizeVietlott')
    <div id="liveResultLottery">
        @include('laravelhtmldomparser::prizes.component.max3dpro',['prize'=>$prizes[0]])    
    </div> 
    @for($rowIndex=1; $rowIndex < count($prizes); $rowIndex++)
        @include('laravelhtmldomparser::prizes.component.max3dpro',['prize'=>$prizes[$rowIndex]])    
    @endfor

</div>  

@include('laravelhtmldomparser::prizes.component.scriptAxiosResult') 
@if($data['checkGetLatestPrize'])
    <script>
        axiosResultLottery("{{$categoryType}}",1);
        setInterval(function(){ 
            axiosResultLottery("{{$categoryType}}",1);
        }, 5000);
    </script>
@endif
@endsection
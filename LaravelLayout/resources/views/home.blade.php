@extends(config('laravelveso.layout'))
@section('content')
    
    <!-- slide show --> 
    @include('laravellayout::components.slideshow')

    <!-- buy tradition lottery -->
    <a href="{{route('buyLottery.buyTraditionalLottery')}}" target="_blank" title="Xổ số Thantai39"><img src="{{asset('/storage/photos/1/Default/buyTraditional.gif')}}" title="Thantai39.vn"></a>

    <!-- buy vietlott -->
    <h2 class="pageSubTitle">MUA HỘ VÉ SỐ VIETLOTT</h2>
    <div class='flex flex-wrap w-full'>
        <!-- buy vietlott mega -->
        <div class='box_vietlott w-1/2 mt-2'>
            <div class="boxTop">
                <img class="w-full" src="{{asset('/storage/photos/1/Default/mega645.png')}}" title="Thantai39.vn">
            </div>
            <div class="boxBottom mega">
                <div class="row1">JACKPOT MEGA 6/45 ƯỚC TÍNH</div>
                <div class="row2">{{$data['mega645Prizes'][0]['prize_value'][0]}}<sup>đ</sup></div>
                <div class="row3"><div class="btnbuy"><a href="{{route('buyLottery.buyMega645')}}" title="Vé số Mega 6/45"><span class="hidden-xs">CHỌN NGAY</span><span class="hidden-md arrow"></span></a></div></div>
            </div>
        </div>
        <!-- buy vietlott power -->
        <div class='box_vietlott w-1/2 mt-2 pl-1'>
            <div class="boxTop">
                <img class="w-full" src="{{asset('/storage/photos/1/Default/power655.png')}}" title="Thantai39.vn">
            </div>
            <div class="boxBottom power">
                <div class="row1">JACKPOT POWER 6/55 ƯỚC TÍNH</div>
                <div class="row2">{{$data['power655Prizes'][0]['prize_value'][0]}}<sup>đ</sup></div>
                <div class="row3"><div class="btnbuy"><a href="{{route('buyLottery.buyPower655')}}" title="Vé số Mega 6/45"><span class="hidden-xs">CHỌN NGAY</span><span class="hidden-md arrow"></span></a></div></div>
            </div>
        </div>
         <!-- buy vietlott max3d -->
         <div class='box_vietlott w-1/2 mt-2'>
            <div class="boxTop">
                <img class="w-full" src="{{asset('/storage/photos/1/Default/max3d.png')}}" title="Thantai39.vn">
            </div>
            <div class="boxBottom max3d">
                <div class="row1">MAX 3D GIÁ TRỊ</div>
                <div class="row2">1.000.000<sup>đ</sup></div>
                <div class="row3"><div class="btnbuy"><a href="{{route('buyLottery.buyMax3D')}}" title="Vé số Mega 6/45"><span class="hidden-xs">CHỌN NGAY</span><span class="hidden-md arrow"></span></a></div></div>
            </div>
        </div>
         <!-- buy vietlott max3dplus -->
         <div class='box_vietlott w-1/2 mt-2 pl-1'>
            <div class="boxTop">
                <img class="w-full" src="{{asset('/storage/photos/1/Default/max3dplus.png')}}" title="Thantai39.vn">
            </div>
            <div class="boxBottom max3dplus">
                <div class="row1">MAX 3D PLUS GIÁ TRỊ</div>
                <div class="row2">1.000.000.000<sup>đ</sup></div>
                <div class="row3"><div class="btnbuy"><a href="{{route('buyLottery.buyMax3DPlus')}}" title="Vé số Mega 6/45"><span class="hidden-xs">CHỌN NGAY</span><span class="hidden-md arrow"></span></a></div></div>
            </div>
        </div>
        <!-- buy vietlott max3dpro -->
        <div class='box_vietlott w-1/2 mt-2'>
            <div class="boxTop">
                <img class="w-full" src="{{asset('/storage/photos/1/Default/max3dpro.png')}}" title="Thantai39.vn">
            </div>
            <div class="boxBottom max3dpro">
                <div class="row1">MAX 3D PRO GIÁ TRỊ</div>
                <div class="row2">2.000.000.000<sup>đ</sup></div>
                <div class="row3"><div class="btnbuy"><a href="{{route('buyLottery.buyMax3DPro')}}" title="Vé số Mega 6/45"><span class="hidden-xs">CHỌN NGAY</span><span class="hidden-md arrow"></span></a></div></div>
            </div>
        </div>
        <!-- buy vietlott keno -->
        <div class='box_vietlott w-1/2 mt-2 pl-1'>
            <div class="boxTop">
                <img class="w-full" src="{{asset('/storage/photos/1/Default/keno.png')}}" title="Thantai39.vn">
            </div>
            <div class="boxBottom keno">
                <div class="row1">KENO GIÁ TRỊ</div>
                <div class="row2">2.000.000.000<sup>đ</sup></div>
                <div class="row3"><div class="btnbuy"><a href="{{route('buyLottery.buyKeno')}}" title="Vé số Mega 6/45"><span class="hidden-xs">CHỌN NGAY</span><span class="hidden-md arrow"></span></a></div></div>
            </div>
        </div>
    </div>
    


    <!-- keno -->
    <h2 class="pageSubTitle pb-2">Xổ số Keno nhanh nhất</h2>

    @include('laravelhtmldomparser::prizes.component.keno',['prize'=>$data['kenoPrizes'][0]]) 

    <!-- div_xstt  -->
    <div class="div_xstt"> 
        <ul id="tab_xstt">
            <li><a href="{{route('prizes.showXosoMienNam')}}">XSMN</a></li>
            <li> <a href="{{route('prizes.showXosoMienTrung')}}">XSMT</a></li>
            <li><a href="{{route('prizes.showXosoMienBac')}}">XSMB</a></li>
            <li><a href="{{route('prizes.showXosoMega645')}}">VietLott</a></li>
        </ul>
    </div>  

    <!-- miennam  -->
    @include('laravelhtmldomparser::prizes.component.styles.miennam') 
    @include('laravelhtmldomparser::prizes.component.miennam',['prizes'=>$data['miennamPrizes']]) 
    <style>.btn-print{display: none !important;}</style> 

@endsection
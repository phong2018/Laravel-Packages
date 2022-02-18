<div class="bangkqxs">
<table class="banginkqxsmiennam miennam3cot">
  <thead>
    <tr style="background:#fe1a00;color:white;">
      <td colspan="{{count($prizes)+1}}" align="center" class="tenbkqxs">
<div class="title"><b>KẾT QUẢ XỔ SỐ  MIỀN TRUNG</b></div>
<div class="service"><i>Kính Chúc Quý Khách May Mắn !</i></div>
<div class="ngaykqxs"><div class="date">
  
<div class="daymonth">{{date("d/m", strtotime($prizes[0]['prize_date']))}}</div>
  <div class="year">{{date("Y", strtotime($prizes[0]['prize_date']))}}</div>

</div></div>
</td>
    </tr>
    <tr>
      <td colspan="{{count($prizes)+1}}" align="center" class="top_adv"><i>Xem KQXS nhanh &amp; chính xác tại:<b>www.thantai39.vn</b></i></td>
    </tr>
    <tr>
      <td class="thu" rowspan="2">T.Tư</td>
      @for($i=count($prizes)-1;$i>=0;$i--)
        <td class="tentinh"> {{$prizes[$i]['province_name']}}</td>
      @endfor
    </tr>
    <tr style="display:none;">
      <td class="matinh">DNG</td><td class="matinh">KH</td>
    </tr>
  </thead>
  <tbody>
  <?php 
      $arrPrize=[['ten_giai_tam','100N','giai_tam'],['ten_giai_bay','200N','giai_bay'],['ten_giai_sau','400N','giai_sau'],['ten_giai_nam','1TR','giai_nam'],['ten_giai_tu','3TR','giai_tu'],['ten_giai_ba','10TR','giai_ba'],['ten_giai_nhi','15TR','giai_nhi'],['ten_giai_nhat','30TR','giai_nhat'],['ten_giai_dac_biet','2TỶ','giai_dac_biet']];

      $rowNumberLoto=[];
    ?>
    @for($prizeIndex=0;$prizeIndex<=8;$prizeIndex++)
    <tr align="center">
       <td class="{{$arrPrize[$prizeIndex][0]}}">{{$arrPrize[$prizeIndex][1]}}</td>
        @for($i=count($prizes)-1;$i>=0;$i--)
          <td class="{{$arrPrize[$prizeIndex][2]}}">
            @foreach($prizes[$i]['prize_number'][8-$prizeIndex] as $num)
            <div class="lq_1">
                @if($num!="")
                  {{$num}}
                  <?php
                      $lengthNum=strlen($num);
                      $preLastNum=substr($num,$lengthNum-2,1);
                      if($prizeIndex==0 || $prizeIndex==8) $colorNum='red';
                      else  if($prizeIndex==1) $colorNum='blue';
                            else $colorNum='black';
                      $rowNumberLoto[$i][$preLastNum][]='<span class="text-'.$colorNum.'-500">'.substr($num,$lengthNum-2,2).'</span>'; 
                  ?>
                @else
                  <span class="spinner-border text-primary"></span>
                @endif 
            </div>
            @endforeach
          </td>
        @endfor 
    </tr>
    @endfor   
  <tr>
      <td colspan="{{count($prizes)+1}}" align="center" class="bottom_adv"><strong>In KQXS từ Website: www.thantai39.vn</strong></td>
    </tr>
    </tbody>
</table>
</div>
<div class='divPrint'>
<a target='_blank' class='btn btn-print' href="{{route('printing.mientrung',['prize_period'=>$prizes[0]['prize_date_Ymd']])}}"><i class="fa fa-fw fa-print"></i> 6 bảng/A4</a>

<a target='_blank' class='btn btn-print' href="{{route('printing.mientrung',['prize_period'=>$prizes[0]['prize_date_Ymd'],'numberPrint'=>4])}}"><i class="fa fa-fw fa-print"></i> 4 bảng/A4</a>

<a target='_blank' class='btn btn-print' href="{{route('printing.mientrung',['prize_period'=>$prizes[0]['prize_date_Ymd'],'numberPrint'=>1])}}"><i class="fa fa-fw fa-print"></i> 1 bảng/A4</a>

</div>

@include('laravelhtmldomparser::prizes.component.showLoto',['labelLoTo'=>'Miền Trung']) 

<br>
 
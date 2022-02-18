<?php 
$weekDate=date('w', strtotime($prizes[0]['prize_date'])); 
$datehasResult=config('laravelhtmldomparser.categoryType.mientrung.datehasResult.'.$weekDate);
 
$prizeTicketType=config('laravelhtmldomparser.categoryType.mientrung.prize_ticketType');
?>

<div class="bangkqxs">
<table class="banginkqxsmiennam miennam3cot">
  <thead>
    <tr>
      <td colspan="{{count($prizes)*2+1}}" align="center" class="tenbkqxs">
<div class="title"><b>KẾT QUẢ XỔ SỐ  MIỀN TRUNG</b></div>
<div class="service">
@include('laravelveso::printing.component.infoAgency')
</div>
<div class="ngaykqxs"><div class="date">
  
<div class="daymonth">{{date("d/m", strtotime($prizes[0]['prize_date']))}}</div>
  <div class="year">{{date("Y", strtotime($prizes[0]['prize_date']))}}</div>

</div></div>
</td>
    </tr>
    <tr>
      <td colspan="{{count($prizes)*2+1}}" align="center" class="top_adv"><i>Xem KQXS nhanh &amp; chính xác tại:<b>www.thantai39.vn</b></i></td>
    </tr>
    <tr>
      <td rowspan='2' class="thu" rowspan="2">T.Tư</td>
      @for($i=count($prizes)-1;$i>=0;$i--)
        <td colspan='2' class="tentinh"> {{$prizes[$i]['province_name']}}</td>
      @endfor
    </tr>
    <tr>
      @foreach($datehasResult as $r )
      <td colspan='2' class="matinh">
      {{$prizeTicketType[$r]}}
      </td>
      @endforeach 
    </tr>
  </thead>
  <tbody>
  <?php 
      $arrPrize=[['ten_giai_tam','100N','giai_tam'],['ten_giai_bay','200N','giai_bay'],['ten_giai_sau','400N','giai_sau'],['ten_giai_nam','1TR','giai_nam'],['ten_giai_tu','3TR','giai_tu'],['ten_giai_ba','10TR','giai_ba'],['ten_giai_nhi','15TR','giai_nhi'],['ten_giai_nhat','30TR','giai_nhat'],['ten_giai_dac_biet','2TỶ','giai_dac_biet']];
    ?>
    @for($prizeIndex=0;$prizeIndex<=8;$prizeIndex++)
    <tr align="center">
       <td class="{{$arrPrize[$prizeIndex][0]}}">{{$arrPrize[$prizeIndex][1]}}</td>
        @for($i=count($prizes)-1;$i>=0;$i--)
          <td colspan='2' class="{{$arrPrize[$prizeIndex][2]}}">
            @foreach($prizes[$i]['prize_number'][8-$prizeIndex] as $num)
            <div class="lq_1">{{$num}}</div>
            @endforeach
          </td>
        @endfor 
    </tr>
    @endfor   
  <tr>
      <td colspan="{{count($prizes)*2+1}}" style='text-align:center' align="center" class="bottom_adv"><strong>In KQXS từ Website: www.thantai39.vn</strong></td>
    </tr>
    </tbody>
</table>
</div>
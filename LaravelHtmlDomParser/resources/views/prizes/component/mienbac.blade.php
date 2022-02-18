<div class="bangkqxs bangkqxsmienbac">
<table class="banginkqxsmienbac">
  <thead>
    <tr style="background:#fe1a00;color:white;">
      <td colspan="2" align="center" class="tenbkqxs"><div class="ngaykqxs"><div class="date">
        
      <div class="daymonth">{{date("d/m", strtotime($prizes[0]['prize_date']))}}</div>
      <div class="year">{{date("Y", strtotime($prizes[0]['prize_date']))}}</div>

    
    </div></div>
    <div class="tenmienxoso">KẾT QUẢ XỔ SỐ MIỀN BẮC </div>
<div class="apdung">(Áp dụng cho khu vực MIỀN BẮC)</div>

</td>
    </tr>
 
  
    <tr style="display:none;">
      <td class="thu">T.Bảy</td><td class="tentinh kyhieuMB"><span class="box_kh bt"><span id="khdb_1" class="khtemp">4MQ</span><span id="khdb_2" class="khtemp">14MQ</span><span id="khdb_3" class="khtemp">5MQ</span><span id="khdb_4" class="khtemp">15MQ</span><span id="khdb_5" class="khtemp">10MQ</span><span id="khdb_6" class="khtemp">6MQ</span></span></td>
     
    </tr>
    
  </thead>
  <tbody>

  <?php 
      $arrPrize=[['ten_giai_bay','G.Bảy','giai_bay'],['ten_giai_sau','G.Sáu','giai_sau'],['ten_giai_nam','G.Năm','giai_nam'],['ten_giai_tu','G.Tư','giai_tu'],['ten_giai_ba','G.Ba','giai_ba'],['ten_giai_nhi','G.Nhì','giai_nhi'],['ten_giai_nhat','G.Nhất','giai_nhat'],['ten_giai_dac_biet','ĐB','giai_dac_biet']];
      $rowNumberLoto=[];
    ?>
    
    @for($prizeIndex=7;$prizeIndex>=0;$prizeIndex--)
    <tr align="center">
       <td class="{{$arrPrize[$prizeIndex][0]}}">{{$arrPrize[$prizeIndex][1]}}</td>
        @for($i=0;$i<count($prizes);$i++)
          <td class="{{$arrPrize[$prizeIndex][2]}}">
            @foreach($prizes[$i]['prize_number'][7-$prizeIndex] as $num)
            <div class="lq_1">
                @if($num!="")
                  {{$num}}
                  <?php
                      $lengthNum=strlen($num);
                      $preLastNum=substr($num,$lengthNum-2,1);
                      if($prizeIndex==0 || $prizeIndex==7) $colorNum='red';
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
      <td colspan="2" align="center" class="bottom_adv"><strong>In KQXS từ Website: www.thantai39.vn</strong></td>
    </tr>
</tbody></table></div>
<div class='divPrint'>
<a target='_blank' class='btn btn-print' href="{{route('printing.mienbac',['prize_period'=>$prizes[0]['prize_date_Ymd']])}}"><i class="fa fa-fw fa-print"></i> 6 bảng/A4</a>


<a target='_blank' class='btn btn-print' href="{{route('printing.mienbac',['prize_period'=>$prizes[0]['prize_date_Ymd'],'numberPrint'=>4])}}"><i class="fa fa-fw fa-print"></i> 4 bảng/A4</a>


<a target='_blank' class='btn btn-print' href="{{route('printing.mienbac',['prize_period'=>$prizes[0]['prize_date_Ymd'],'numberPrint'=>1])}}"><i class="fa fa-fw fa-print"></i>1 bảng/A4</a>

</div> 


@include('laravelhtmldomparser::prizes.component.showLoto',['labelLoTo'=>'Miền Bắc']) 

<br>
 
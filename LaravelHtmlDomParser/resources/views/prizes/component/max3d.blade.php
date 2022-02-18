<div class="bangkqxs" id="bangkqxs_0"><table width="100%" cellpadding="0" cellspacing="0" border="1" class="tblMax3D">
		<tbody><tr style="background: #701255; color:white;">
			<td width="80%" align="center" style="padding-bottom:9px;padding-top:9px;">
         <img  class='hidden'  src="{{asset('/storage/photos/1/Default/max3d.png')}}" alt="" class="w-20 ">   
         <div class="infoDL">KẾT QUẢ XỔ SỐ</div><div class="address">MAX 3D 
         - Kỳ {{$prize['prize_period']}} 
         </div></td>
			<td align="center"><span class="ngay">{{date("d/m", strtotime($prize['prize_date']))}}</span><br><span class="nam">{{date("Y", strtotime($prize['prize_date']))}}</span></td>
		</tr>
		<tr>
			<td colspan="2" class="box_result">
				<table width="98%" align="center" border="0">
					<tbody> 
				</tbody></table>
			</td>	
		</tr>
		<tr>
			<td colspan="2" style="border-top:0; border-bottom:0">
				 <table border="1" class="table_max3d" width="98%">
                     <thead>
                        <tr>
                           <th width="20%">Max 3D</th>
                           <th>Số Quay Thưởng</th>
                           <th width="20%">Max 3D+</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td><strong>Đặc biệt<br><span class="giaiMax3d">1Tr</span></strong></td>
                           <td class="max3d_number max3d_g1">
                               @foreach($prize['prize_number'][0] as $num)<div>{{$num}}</div>@endforeach
                           </td>
                           <td><strong>Đặc biệt<br><span class="giaiMax3d">1Tỷ</span></strong></td>
                        </tr>
                        <tr>
                           <td><strong>Giải nhất<br><span class="giaiMax3d">350K</span></strong></td>
                           <td class="max3d_number"> 
                               @foreach($prize['prize_number'][1] as $num)<div>{{trim($num)}}</div>@endforeach
                           </td>
                           <td><strong>Giải nhất<br><span class="giaiMax3d">40Tr</span></strong></td>
                        </tr>
                        <tr>
                           <td><strong>Giải nhì<br><span class="giaiMax3d">210K</span></strong></td>
                           <td class="max3d_number max3d_g3">
                              @foreach($prize['prize_number'][2] as $num)<div>{{trim($num)}}</div>@endforeach 
                           </td>
                           <td><strong>Giải nhì<br><span class="giaiMax3d">10Tr</span></strong></td>
                        </tr>
                        <tr>
                           <td><strong>Giải ba<br><span class="giaiMax3d">100K</span></strong></td>
                           <td class="max3d_number max3d_g3">
                              @foreach($prize['prize_number'][3] as $num)<div>{{trim($num)}}</div>@endforeach
                           </td>
                           <td><strong>Giải ba<br><span class="giaiMax3d">5Tr</span></strong></td>
                        </tr>
                       <tr>
               <td colspan="2"><span class="noteGiai">(Max 3D+) Trùng 2 bộ số bất kỳ trong 20 bộ số của giải Đặc biệt, Nhất, Nhì và Ba</span></td>
               <td><strong>Giải tư<br><span class="giaiMax3d">1Tr</span></strong></td>
            </tr>
            <tr>
               <td colspan="2"><span class="noteGiai">(Max 3D+) Trùng 1 trong 2 bộ số của giải Đặc biệt</span></td>
               <td><strong>Giải năm<br><span class="giaiMax3d">150K</span></strong></td>
            </tr>
            <tr>
               <td colspan="2"><span class="noteGiai">(Max 3D+) Trùng 1 bộ số bất kỳ trong 18 bộ số của giải Nhất, Nhì, Ba trừ 2 bộ của giải Đặc biệt</span></td>
               <td><strong>Giải sáu<br><span class="giaiMax3d">40K</span></strong></td>
            </tr>
                    </tbody>
                </table>
			</td>
		</tr>
   		<tr>
           <td colspan="2" class="introduct">Chúc quý khách may mắn !
           </td>
       </tr>
	</tbody></table></div>
   <div class='divPrint'>
   <a target='_blank' class='btn btn-print' href="{{route('printing.max3d',['prize_period'=>str_replace('#','',$prize['prize_period'])])}}"><i class="fa fa-fw fa-print"></i> 6 bảng/A4 </a>

   <a target='_blank' class='btn btn-print' href="{{route('printing.max3d',['prize_period'=>str_replace('#','',$prize['prize_period']),'numberPrint'=>4])}}"><i class="fa fa-fw fa-print"></i> 4 bảng/A4 </a>

   <a target='_blank' class='btn btn-print' href="{{route('printing.max3d',['prize_period'=>str_replace('#','',$prize['prize_period']),'numberPrint'=>1])}}"><i class="fa fa-fw fa-print"></i> 1 bảng/A4 </a>

   </div> 
<br>
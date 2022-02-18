<?php
use Phonglg\LaravelLayout\Helpers\NumberHelper;
?>
<div class="bangkqxs" id="bangkqxs_0"><table width="100%" cellpadding="0" cellspacing="0" border="1" class="tblMega645">
		<tbody><tr>
			<td width="80%" align="center" class="header_vedo" style="padding-bottom:9px;padding-top:9px;">
			<img class='hidden' src="{{asset('/storage/photos/1/Default/power655.png')}}" alt="" class="w-20 ">	
			<div class="infoDL">KẾT QUẢ XỔ SỐ</div><div class="address">POWER 6/55
			- Kỳ {{$prize['prize_period']}} 
			</div></td>
			<td align="center" class="header_vedo"><span class="ngay">
			{{date("d/m", strtotime($prize['prize_date']))}}	
			</span><br><span class="nam">
			{{date("Y", strtotime($prize['prize_date']))}}
			</span></td>
		</tr>
		<tr>
			<td colspan="2" class="box_result">
				<table width="95%" align="center" border="0">
					<tbody> 
					<tr>
						@for($i=0;$i<count($prize['prize_number'][5])-1;$i++)
							<td align="center">
								<span  class="result_number"> 
									@if($prize['prize_number'][5][$i]!="")
										{{$prize['prize_number'][5][$i]}}
									@else
									<span class="spinner-border text-primary"></span>
									@endif  
								</span>
							</td>
						@endfor 
                        <td align="center">
							<span class="result_number jpPhu"> 
									@if($prize['prize_number'][5][$i]!="")
										{{$prize['prize_number'][5][$i]}}
									@else
									<span class="spinner-border text-primary"></span>
									@endif  
							</span>
						</td> 
					</tr>
					<tr>
						<td colspan="7" align="center" class="title_slgiai">Số lượng giải trúng - kỳ này:</td>
					</tr>	
				</tbody></table>
			</td>	
		</tr>
		<tr>
			<td colspan="2" style="border-top:0">
				<table width="95%" border="1" class="tblTKGiai">
					<thead>
						<tr>
							<th>Giải</th>
							<th>Trùng</th>
							<th>SL</th>
							<th>Giá trị</th>
						</tr>	
					</thead>
					<tbody>
						<tr>
							<td align="center">Jackpot 1</td>
							<td align="center">6 số</td>
							<td align="center">{{$prize['prize_quantity'][0]}}</td>
							<td align="center">
								@if( NumberHelper::isNumber($prize['prize_value'][0]) )
									≈ {{number_format((str_replace([',','.'],"",$prize['prize_value'][0]))/1000000000,1)}}tỉ
								@else
									{{$prize['prize_value'][0]}}
								@endif 
								</td>
						</tr>
                                                <tr>
							<td align="center">Jackpot 2</td>
							<td align="center">5 số + 1*</td>
							<td align="center">{{$prize['prize_quantity'][1]}}</td>
							<td align="center">
								@if( NumberHelper::isNumber($prize['prize_value'][0]) )
									≈ {{number_format((str_replace([',','.'],"",$prize['prize_value'][1]))/1000000000,1)}}tỉ
								@else
									{{$prize['prize_value'][1]}}
								@endif 	 
							</td>
						</tr>
						<tr>
							<td align="center">Giải nhất</td>
							<td align="center">5 số</td>
							<td align="center">{{$prize['prize_quantity'][2]}}</td>
							<td align="center">40 Triệu</td>
						</tr>
						<tr>
							<td align="center">Giải nhì</td>
							<td align="center">4 số</td>
							<td align="center">{{$prize['prize_quantity'][3]}}</td>
							<td align="center">500.000đ</td>
						</tr>
						<tr>
							<td align="center">Giải ba</td>
							<td align="center">3 số</td>
							<td align="center">{{$prize['prize_quantity'][4]}}</td>
							<td align="center">50.000đ</td>
						</tr>
                                                <tr>
                                                        <td align="center" colspan="4"><i><b>Lưu ý</b>: <b>1*</b> là trùng với cặp số thứ 7</i></td>
                                                </tr>
					</tbody>	
				</table>
                                <div class="jackpot_kysau"><div class="jackpot_title">Giá trị Jackpot 1</div><div class="jackpot_price">{{$prize['prize_value'][0]}}<sup></sup></div><div class="break_jackpot"></div><div class="jackpot_title">Giá trị Jackpot 2</div><div class="jackpot_price">{{$prize['prize_value'][1]}}<sup></sup></div></div>
			</td>
		</tr>
		<tr>
			<td colspan="7" class="introduct">
			  Trực tiếp <strong>Power 6/55</strong> vào lúc <strong>18h10p</strong> các ngày <strong>thứ 3, 5, 7</strong> tại website: <strong>www.thantai39.vn</strong><div class="end_footer">Chúc quý khách may mắn!</div>
			</td>
		</tr>
	</tbody></table></div> 
	<div class='divPrint'>
	<a target='_blank' class='btn btn-print' href="{{route('printing.power655',['prize_period'=>str_replace('#','',$prize['prize_period'])])}}"><i class="fa fa-fw fa-print"></i> 6 bảng/A4</a>

	<a target='_blank' class='btn btn-print' href="{{route('printing.power655',['prize_period'=>str_replace('#','',$prize['prize_period']),'numberPrint'=>4])}}"><i class="fa fa-fw fa-print"></i> 4 bảng/A4 </a>

	<a target='_blank' class='btn btn-print' href="{{route('printing.power655',['prize_period'=>str_replace('#','',$prize['prize_period']),'numberPrint'=>1])}}"><i class="fa fa-fw fa-print"></i> 1 bảng/A4 </a>

	</div> 
<br>
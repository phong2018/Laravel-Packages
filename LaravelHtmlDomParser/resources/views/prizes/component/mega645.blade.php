<?php
use Phonglg\LaravelLayout\Helpers\NumberHelper;
?>
<div class="bangkqxs" ><table width="100%" cellpadding="0" cellspacing="0" border="1" class="tblMega645">
		<tbody><tr>
			<td width="80%" align="center" style="padding-bottom:9px;padding-top:9px;">
			<img  class='hidden' src="{{asset('/storage/photos/1/Default/mega645.png')}}" alt="" class="w-20 ">
			<div class="infoDL">KẾT QUẢ XỔ SỐ</div><div class="address">MEGA 6/45

			- Kỳ {{$prize['prize_period']}} 

			</div></td>
			<td align="center"><span class="ngay">
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
						@foreach($prize['prize_number'][count($prize['prize_number'])-1] as $num)
						<td align="center"><span  class="result_number"> 
						
							@if($num!="")
							{{$num}}
							@else
							<span class="spinner-border text-primary"></span>
							@endif 

						</span ></td>
						@endforeach 
					</tr>
					<tr>
						<td colspan="6" align="center" class="title_slgiai">Số lượng giải trúng - kỳ này:</td>
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
							<td align="center">Jackpot</td>
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
							<td align="center">Giải nhất</td>
							<td align="center">5 số</td>
							<td align="center">{{$prize['prize_quantity'][1]}}</td>
							<td align="center">10 Triệu</td>
						</tr>
						<tr>
							<td align="center">Giải nhì</td>
							<td align="center">4 số</td>
							<td align="center">{{$prize['prize_quantity'][2]}}</td>
							<td align="center">300.000đ</td>
						</tr>
						<tr>
							<td align="center">Giải ba</td>
							<td align="center">3 số</td>
							<td align="center">{{$prize['prize_quantity'][3]}}</td>
							<td align="center">30.000đ</td>
						</tr>
					</tbody>	
				</table>
                            
					<div class="jackpot_kysau"><div class="jackpot_title">JACKPOT kỳ sau</div>
					
					<div class="jackpot_price"> 
									{{$prize['prize_value'][0]}}
									</div></div>
			</td>
		</tr>
		<tr>
			<td colspan="6" align="center" class="introduct">
			  Kết quả xổ số <strong>Mega 6/45</strong> được tường thuật trực tiếp trên kênh <strong>Today TV</strong> vào lúc <strong>18h10p</strong> các ngày <strong>thứ 4</strong>, <strong>thứ 6</strong>, <strong>chủ nhật</strong> và được tường thuật trực tiếp tại website: <span class="domain">www.thantai39.vn</span><div class="end_footer">Kính chúc quý khách may mắn!</div>
			</td>
		</tr>
	</tbody></table></div>
  
	<div class='divPrint'>
	<a target='_blank' class='btn btn-print' href="{{route('printing.mega645',['prize_period'=>str_replace('#','',$prize['prize_period'])])}}"><i class="fa fa-fw fa-print"></i> 6 bảng/A4</a>

	<a target='_blank' class='btn btn-print' href="{{route('printing.mega645',['prize_period'=>str_replace('#','',$prize['prize_period']),'numberPrint'=>4])}}"><i class="fa fa-fw fa-print"></i>4 bảng/A4 </a>

	<a target='_blank' class='btn btn-print' href="{{route('printing.mega645',['prize_period'=>str_replace('#','',$prize['prize_period']),'numberPrint'=>1])}}"><i class="fa fa-fw fa-print"></i> 1 bảng/A4 </a>

	</div> 
<br>
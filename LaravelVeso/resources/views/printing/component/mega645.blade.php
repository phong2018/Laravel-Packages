<div class="bangkqxs" ><table width="100%" cellpadding="0" cellspacing="0" border="1" class="tblMega645">
		<tbody><tr>
			<td width="80%" align="center">
			<div class="infoDL">
			@include('laravelveso::printing.component.infoAgency')
			</div>
			</td>
			<td align="center"><span class="ngay">
			{{date("d/m", strtotime($prizes['prize_date']))}}	
			</span><br><span class="nam">
			{{date("Y", strtotime($prizes['prize_date']))}}
			</span></td>
		</tr>
		<tr>
			<td colspan="2" class="box_result">
				<table width="95%" align="center" border="0">
					<tbody><tr>
						<td colspan="6" align="center" class="title_kqxs">Kết quả xổ số Mega 6/45</td>
					</tr>	
					<tr>
						@foreach($prizes['prize_number'][count($prizes['prize_number'])-1] as $num)
						<td align="center" class="result_number">{{$num}}</td>
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
							<td align="center">{{$prizes['prize_quantity'][0]}}</td>
							<td align="center">{{$prizes['prize_value'][0]}}đ</td>
						</tr>
						<tr>
							<td align="center">Giải nhất</td>
							<td align="center">5 số</td>
							<td align="center">{{$prizes['prize_quantity'][1]}}</td>
							<td align="center">10 Triệu</td>
						</tr>
						<tr>
							<td align="center">Giải nhì</td>
							<td align="center">4 số</td>
							<td align="center">{{$prizes['prize_quantity'][2]}}</td>
							<td align="center">300.000đ</td>
						</tr>
						<tr>
							<td align="center">Giải ba</td>
							<td align="center">3 số</td>
							<td align="center">{{$prizes['prize_quantity'][3]}}</td>
							<td align="center">30.000đ</td>
						</tr>
					</tbody>	
				</table>
                            
					<div class="jackpot_kysau"><div class="jackpot_title">JACKPOT kỳ sau</div><div class="jackpot_price"> 
									{{$prizes['prize_value'][0]}}
									<sup>đ</sup></div></div>
			</td>
		</tr>
		<tr>
			<td colspan="6" align="center" class="introduct">
			  Kết quả xổ số <strong>Mega 6/45</strong> được tường thuật trực tiếp trên kênh <strong>Today TV</strong> vào lúc <strong>18h10p</strong> các ngày <strong>thứ 4</strong>, <strong>thứ 6</strong>, <strong>chủ nhật</strong> và được tường thuật trực tiếp tại website: <span class="domain">www.thantai39.vn</span><div class="end_footer">Kính chúc quý khách may mắn!</div>
			</td>
		</tr>
	</tbody></table></div>
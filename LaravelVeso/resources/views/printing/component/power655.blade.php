<div class="bangkqxs" id="bangkqxs_0"><table width="100%" cellpadding="0" cellspacing="0" border="1" class="tblMega645">
		<tbody><tr>
			<td width="80%" align="center" class="header_vedo"><div class="infoDL">
			@include('laravelveso::printing.component.infoAgency')
			</div></td>
			<td align="center" class="header_vedo"><span class="ngay">
			{{date("d/m", strtotime($prizes['prize_date']))}}	
			</span><br><span class="nam">
			{{date("Y", strtotime($prizes['prize_date']))}}
			</span></td>
		</tr>
		<tr>
			<td colspan="2" class="box_result">
				<table width="95%" align="center" border="0">
					<tbody><tr>
						<td colspan="8" align="center" class="title_kqxs">Kết quả xổ số Power 6/55</td>
					</tr>	
					<tr>
						@for($i=0;$i<count($prizes['prize_number'][5])-1;$i++)
							<td align="center" class="result_number">{{$prizes['prize_number'][5][$i]}}</td>
						@endfor
						<td align="center" class="sub_jp">|</td>
                        <td align="center" class="result_number jpPhu">{{$prizes['prize_number'][5][$i]}}</td> 
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
							<td align="center">Jackpot1</td>
							<td align="center">6 số</td>
							<td align="center">{{$prizes['prize_quantity'][0]}}</td>
							<td align="center">{{$prizes['prize_value'][0]}}</td>
						</tr>
                                                <tr>
							<td align="center">Jackpot2</td>
							<td align="center">5 số + 1*</td>
							<td align="center">{{$prizes['prize_quantity'][1]}}</td>
							<td align="center">{{$prizes['prize_value'][1]}}</td>
						</tr>
						<tr>
							<td align="center">Giải nhất</td>
							<td align="center">5 số</td>
							<td align="center">{{$prizes['prize_quantity'][2]}}</td>
							<td align="center">40 Triệu</td>
						</tr>
						<tr>
							<td align="center">Giải nhì</td>
							<td align="center">4 số</td>
							<td align="center">{{$prizes['prize_quantity'][3]}}</td>
							<td align="center">500.000đ</td>
						</tr>
						<tr>
							<td align="center">Giải ba</td>
							<td align="center">3 số</td>
							<td align="center">{{$prizes['prize_quantity'][4]}}</td>
							<td align="center">50.000đ</td>
						</tr>
                                                <tr>
                                                        <td align="center" colspan="4"><i><b>Lưu ý</b>: <b>1*</b> là trùng với cặp số thứ 7</i></td>
                                                </tr>
					</tbody>	
				</table>
                                <div class="jackpot_kysau"><div class="jackpot_title">JACKPOT 1 kỳ sau</div><div class="jackpot_price">{{$prizes['prize_value'][0]}}<sup>đ</sup></div><div class="break_jackpot"></div><div class="jackpot_title">JACKPOT 2 kỳ sau</div><div class="jackpot_price">{{$prizes['prize_value'][1]}}<sup>đ</sup></div></div>
			</td>
		</tr>
		<tr>
			<td colspan="7" class="introduct">
			  Trực tiếp <strong>Power 6/55</strong> vào lúc <strong>18h10p</strong> các ngày <strong>thứ 3, 5, 7</strong> tại website: <strong>www.thantai39.vn</strong><div class="end_footer">Chúc quý khách may mắn!</div>
			</td>
		</tr>
	</tbody></table></div>
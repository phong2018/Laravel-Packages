<div class="bangkqxs" id="bangkqxs_0"><table width="100%" cellpadding="0" cellspacing="0" border="1" class="tblMax3D">
		<tbody><tr>
			<td width="80%" align="center"><div class="infoDL">
         @include('laravelveso::printing.component.infoAgency')
         </div></td>
			<td align="center"><span class="ngay">{{date("d/m", strtotime($prizes['prize_date']))}}</span><br><span class="nam">{{date("Y", strtotime($prizes['prize_date']))}}</span></td>
		</tr>
		<tr>
			<td colspan="2" class="box_result">
				<table width="98%" align="center" border="0">
					<tbody><tr>
						<td colspan="6" align="center" class="title_kqxs">Xổ số điện toán Max3D Pro</td>
					</tr>	
				</tbody></table>
			</td>	
		</tr>
		<tr>
			<td colspan="2" style="border-top:0; border-bottom:0">
				 <table border="1" class="table_max3d" width="98%">
                     <thead>
                        <tr>
                           <th width="20%">Giải</th>
                           <th>Số Quay Thưởng</th>
                           <th width="20%">Giá Trị</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td><strong>Đặc biệt</strong></td>
                           <td class="max3d_number max3d_g1">
                              @foreach($prizes['prize_number'][0] as $num)<div>{{$num}}</div>@endforeach
                           </td>
                           <td><strong><span class="giaiMax3d">2 Tỷ</span></strong></td>
                        </tr>
                        <tr>
                           <td><strong>Giải nhất</strong></td>
                           <td class="max3d_number">
                           @foreach($prizes['prize_number'][1] as $num)<div>{{$num}}</div>@endforeach
                           </td>
                           <td><strong><span class="giaiMax3d">30Tr</span></strong></td>
                        </tr>
                        <tr>
                           <td><strong>Giải nhì</strong></td>
                           <td class="max3d_number max3d_g3">
                           @foreach($prizes['prize_number'][2] as $num)<div>{{$num}}</div>@endforeach
                           </td>
                           <td><strong><span class="giaiMax3d">10Tr</span></strong></td>
                        </tr>
                        <tr>
                           <td><strong>Giải ba</strong></td>
                           <td class="max3d_number max3d_g3">
                           @foreach($prizes['prize_number'][3] as $num)<div>{{$num}}</div>@endforeach
                           </td>
                           <td><strong><span class="giaiMax3d">4Tr</span></strong></td>
                        </tr>
                        <tr>
                           <td><strong>ĐB phụ</strong></td>
                           <td><span class="noteGiai">Trùng 02 bộ số của giải Đặc biệt ngược thứ tự quay</span></td>
                           <td><strong><span class="giaiMax3d">400Tr</span></strong></td>
                        </tr>
                        <tr>
                           <td><strong>Giải tư</strong></td>
                           <td><span class="noteGiai">Trùng 2 bộ số  bất kỳ của giải Đặc biệt, Nhất, Nhì, Ba</span></td>
                           <td><strong><span class="giaiMax3d">1Tr</span></strong></td>
                        </tr>
                        <tr>
                           <td><strong>Giải năm</strong></td>
                           <td><span class="noteGiai">Trùng 1 bộ số bất kỳ của giải Đặc biệt</span></td>
                           <td><strong>Giải năm<br><span class="giaiMax3d">100K</span></strong></td>
                        </tr>
                        <tr>
                           <td><strong>Giải sáu</strong></td>
                           <td><span class="noteGiai">Trùng 1 bộ số bất kỳ của giải Nhất, Nhì, Ba</span></td>
                           <td><strong><span class="giaiMax3d">40K</span></strong></td>
                        </tr>
                    </tbody>
                </table>
			</td>
		</tr>
   		<tr>
           <td colspan="2" class="introduct"><i>In KQXS từ Website: www.thantai39.vn</i></td>
       </tr>
	</tbody></table></div>
<?php
	$even=0;$odd=0;$big=0;$small=0;
	foreach($prize['prize_number'] as $num) {
		if($num % 2==0) $even++;
		else $odd++;
		if($num > 40) $big++;
		else $small++;
	}
	?>
	<div class='w-full wrapKeno'> 
	<table class='w-full'>
	<tr class='infoKeno'><td class='periodKeno'>Kỳ: {{$prize['prize_period']}}</td><td class='text-right'>Ngày {{date("d/m/Y", strtotime($prize['prize_date']))}} &nbsp{{$prize['prize_time']}}</td></tr>
	<tr><td colspan="2" class='w-full text-center'> 
		@for($i=0;$i<10;$i++)
			<span  class='numKeno'>{{$prize['prize_number'][$i]}}</span>
		@endfor 
	</td></tr>
	<tr><td colspan="2" class='w-full text-center'> 
		@for($i=10;$i<20;$i++)
			<span  class='numKeno'>{{$prize['prize_number'][$i]}}</span>
		@endfor 
	</td></tr>
	<tr><td colspan="2" class="text-center"><span class="kenoTK text-blue-400">Chẳn ({{$even}})</span><span class="kenoTK  text-red-400">Lẻ ({{$odd}})</span> <span class="kenoTK  text-yellow-700">Lớn ({{$big}})</span><span class="kenoTK text-green-400">Nhỏ ({{$small}})</span></td></tr>
	</table>
	</div>

<div class='flex flex-row  flex-wrap mb-2'> 

@for($i=0;$i< count($prizes); $i++)
    @if(isset($prizes[$i]))
        @if($i==count($prizes)) 
        <a href="{{route($data['routeShowPrizeResult'],['prize_period'=>str_replace('#','',$prizes[$i]['prize_period'])])}}" class='ml-1  mb-1  pl-3 pr-3 pt-1 pb-1 border rounded bg-red-500 inline-block text-white font-bold text-center'>{{$prizes[$i]['prize_period']}}</a>
        @else
        <a href="{{route($data['routeShowPrizeResult'],['prize_period'=>str_replace('#','',$prizes[$i]['prize_period'])])}}" class='ml-1 mb-1 pl-3 pr-3 pt-1 pb-1 border rounded bg-yellow-200 inline-block font-bold text-center'>{{$prizes[$i]['prize_period']}}</a>
        @endif
    @endif
@endfor
</div>


<div class='flex flex-row justify-around mb-2'>
@for($i=count($prizes)-1;$i>=count($prizes)-5;$i--)
    @if(isset($prizes[$i]))
        @if($i==count($prizes)-5) 
        <a href="{{route($data['routeShowPrizeResult'],['prize_period'=>str_replace('#','',$prizes[$i]['prize_period'])])}}" class='pl-2 pr-2 md:pl-4 md:pr-4 pt-1 pb-1 border rounded bg-red-500 inline-block text-white font-bold text-center'>{{substr($prizes[$i]['prize_date'],0,5)}}</a>
        @else
        <a href="{{route($data['routeShowPrizeResult'],['prize_period'=>str_replace('#','',$prizes[$i]['prize_period'])])}}" class='pl-2 pr-2 md:pl-4 md:pr-4 pt-1 pb-1 border rounded bg-yellow-200 inline-block font-bold text-center'>{{substr($prizes[$i]['prize_date'],0,5)}}</a>
        @endif
    @endif
@endfor

@if($data['prizesTempLast'] && isset($data['prizesTempLast'][0])) 
 
<a href="{{route($data['routeShowPrizeResult'],['prize_period'=>str_replace('#','',$data['prizesTempLast'][0]->prize_period)])}}" class='pl-2 pr-2 md:pl-4 md:pr-4 pt-1 pb-1 border rounded bg-yellow-200 inline-block font-bold text-center'>{{str_replace('-','/',substr(date('d-m-y',strtotime($data['prizesTempLast'][0]->prize_date)),0,5))}}</a>
@endif
</div>

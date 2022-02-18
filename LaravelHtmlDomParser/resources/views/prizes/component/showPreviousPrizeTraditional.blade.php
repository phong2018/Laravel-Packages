
<div class='flex flex-row justify-around mb-2'>
@for($i=count($prizesResult)-1;$i>=count($prizesResult)-5;$i--)
    @if(count($prizesResult[$i])>0)
        @if($i==count($prizesResult)-5) 
        <a href="{{route($data['routeShowPrizeResult'],['prize_period'=>$prizesResult[$i][0]['prize_date_Ymd']])}}" class='pl-2 pr-2 md:pl-4 md:pr-4 pt-1 pb-1 border rounded bg-red-500 inline-block text-white font-bold text-center'>{{str_replace('-','/',substr($prizesResult[$i][0]['prize_date'],0,5))}}</a>
        @else
        <a href="{{route($data['routeShowPrizeResult'],['prize_period'=>$prizesResult[$i][0]['prize_date_Ymd']])}}" class='pl-2 pr-2 md:pl-4 md:pr-4 pt-1 pb-1 border rounded bg-yellow-200 inline-block font-bold text-center'>{{str_replace('-','/',substr($prizesResult[$i][0]['prize_date'],0,5))}}</a>
        @endif
    @endif
@endfor

<a href="{{route($data['routeShowPrizeResult'],['prize_period'=> $data['prizesTempLast']])}}" class='pl-2 pr-2 md:pl-4 md:pr-4 pt-1 pb-1 border rounded bg-yellow-200 inline-block font-bold text-center'>{{str_replace('-','/',substr(date('d-m-y',strtotime($data['prizesTempLast'])),0,5))}}</a>
</div>

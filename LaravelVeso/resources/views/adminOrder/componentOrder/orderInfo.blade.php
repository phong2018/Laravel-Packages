<table> 
    <td>
        <p><span class='font-bold'>{{ $orderDetail->name }}</span>. 
            @if($detail['category']!='keno')   
            <span>{{$data['methodsToPlay'][$detail['methodSelected']]['name']}}</span>
            @endif

            @if($detail['category']=='keno')   
            <span>{{$data['methodsToPlayKeno'][$detail['methodSelected']]['name']}}</span>
            @endif
        </p>
       
        <p>{{ $orderDetail->prize_date }} </p>

        <p>Số lượng: {{$orderDetail->qty}}.<span> Giá vé: {{ number_format($orderDetail->price) }}Đ</span></p>
        
        @foreach ($detail['blocksNumber'] as $noPeriod=>$block)
            @if($block)
                <div>
                <span class='text-blue-500'> #{{$data['blocks'][$noPeriod].": "}}</span>
                    <span class='font-bold'>
                        <!-- case keno ChanLe-LonNho -->
                        @if($detail['category']==config('laravelhtmldomparser.categoryType.keno.key') && $detail['methodSelected']>9 )   
                            <?php $arr=$data['methodsToPlayKeno'][$detail['methodSelected']]['key'];?>
                            @for($i=0;$i< count($block);$i++)
                                @if($block[$i]==1)
                                    {{$arr[$i]}}
                                    @break
                                @endif
                            @endfor
                        <!-- for other game -->
                        @else 
                            @foreach($block as $num)
                                {{$num}}
                            @endforeach
                        @endif
                    </span>
                    <!-- show price for every block -->
                    
                    @if (isset($detail['priceBlocks'][$noPeriod]))
                    - Giá: {{number_format($detail['priceBlocks'][$noPeriod])."Đ"}}
                    @endif 
                </div> 
            @endif
        @endforeach  
        
    </td>
</table>


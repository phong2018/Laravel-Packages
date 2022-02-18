
@if($detail['category']!=config('laravelhtmldomparser.categoryType.traditionallottery.key'))
    @foreach ($detail['blocksNumber'] as $no=>$block)
        @if($block)
            <div>
                <span class='text-blue-500'>#{{$data['blocks'][$no].": "}}</span>

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
                        <span class='font-bold'>{{$num}}</span>
                    @endforeach
                @endif

                <!-- show price for every block -->
                
                @if (isset($detail['priceBlocks'][$no]))
                - Giá: {{number_format($detail['priceBlocks'][$no])."Đ"}}
                @endif 
                
            </div> 
        @endif
    @endforeach 

    <?php 
    $arr=$detail['buyingPeriods']; sort($arr);
    ?>
    
    Kỳ:
    @foreach ($arr as $noP=>$period)
        @if($period)
             <span class='font-bold'>#{{$period}} </span> &nbsp   
        @endif
    @endforeach
@endif

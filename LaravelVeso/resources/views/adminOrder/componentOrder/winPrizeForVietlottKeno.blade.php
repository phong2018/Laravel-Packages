
<!-- ================ -->
<?php $checkWin=false;?>
@foreach($winPrize[$noBlock] as $noWin=>$win)
    @if($win[1]>0)
        <?php $checkWin=true;?>
    @endif
@endforeach
<!-- ================ -->

<!-- ================ -->
@if($checkWin)
<span class='font-bold'>
 @if($detail['methodSelected']>9)   
        @if($win[1]>0)
            #{{$data['blocks'][$noBlock].": "}}
            <?php $arr=$data['methodsToPlayKeno'][$detail['methodSelected']]['key'];?>
            @for($i=0;$i< count($block);$i++)
                @if($block[$i]==1)
                    {{$arr[$i]}}
                    @break
                @endif
            @endfor 
        @endif
    @else
        @if($win[1]>0)     
            #{{$data['blocks'][$noBlock].": "}}
            
            @foreach($block as $num)
                {{$num}} 
            @endforeach
        @endif
    @endif 
</span>
@endif
<!-- ================ -->

<!-- ================ -->
@foreach($winPrize[$noBlock] as $noWin=>$win)
@if($win[1]>0)
<div class='overflow-hidden'>
<!-- keno even-odd big-small -->
    <i class="fas fa-angle-right"></i>
    @if($detail['methodSelected']>9)   
        @if($win[1]>0)
             Trúng thưởng <span class='text-red-500' >{{number_format($win[1])}}Đ</span> 
        @endif
    @else
        @if($win[1]>0)    
            Trùng {{$win[0]}} số 
            Trúng thưởng: <span class='text-red-500' >{{number_format($win[1])}}Đ</span> 
         
        @endif
    @endif
    
    @if($win[1]>0)    

        @include('laravelveso::adminOrder.componentOrder.checkSubmitWinPrize') 
        
    @endif
</div> 
          
@endif
@endforeach
<!-- ================ -->
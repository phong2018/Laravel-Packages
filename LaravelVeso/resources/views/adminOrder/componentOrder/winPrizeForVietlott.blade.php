<?php 
use Phonglg\LaravelLayout\Helpers\NumberHelper;
?>

<!-- ================ -->
<?php $checkWin=false;?>
@foreach($winPrize[$noBlock] as $noWin=>$win)
    @if($win) 
        <?php $checkWin=true;?>
    @endif
@endforeach
<!-- ================ -->

<!-- ================ -->
@if($checkWin)
<span class='font-bold'>
#{{$data['blocks'][$noBlock].": "}}
@foreach($block as $num)
{{$num}} 
@endforeach
</span>
@endif
<!-- ================ -->

<!-- ================ -->
@foreach($winPrize[$noBlock] as $noWin=>$win)
@if($win) 
<div class='overflow-hidden'>  
    @if($win[1]!='') 
        <i class="fas fa-angle-right"></i>
        <span class='text-red-500'>
            {{ $win[0] }}
            @if( NumberHelper::isNumber( $win[1]) )  
                    {{number_format($win[1])}}Đ
            @else 
                @if($win[0]!=$win[1])
                    {{$win[1]}}
                @endif
            @endif
        </span> 
 
        @include('laravelveso::adminOrder.componentOrder.checkSubmitWinPrize')   
    @endif
</div>
@endif
@endforeach
<!-- ================ -->
 
<?php 
    $detail=$orderDetail->options;
    $orderDetailId=$orderDetail->id; 
    if(!isset($showStatusOrder)) $showStatusOrder=true;
    if(!isset($showFunction)) $showFunction=true; 
?>
<table class="w-full">
<tr>
    <td class='align-top pr-3  w-20'>
        <img src="{{ url($orderDetail->options['image']) }}" alt="" class="w-20  ">
    </td>

    <td>
        @include('laravelveso::adminOrder.componentOrder.orderInfo') 
        <?php 
        $periods=$detail['buyingPeriods']; 
        if(isset($detail['specificPeriods'])) $specificPeriods=$detail['specificPeriods']; 
        $periodStatus=$detail['periodStatus']; 
        ?>
       
        @include('laravelveso::adminOrder.componentOrder.ajaxUploadFile')  

        <table  class="w-full">
            @foreach ($periods as $noPeriod=>$period)
                @include('laravelveso::adminOrder.componentOrder.vietlottDetailPeriod') 
            @endforeach

        </table>
    </td>
</tr>
</table>




 

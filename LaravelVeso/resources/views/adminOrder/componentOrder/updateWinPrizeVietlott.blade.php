
    <!-- update winPrize -->
    @can('admin-updateOrderDetail')
    <span class='text-red-500 italic inline-block' id='msg-{{$orderDetail->id}}-{{$noPeriod}}'></span>

    <span id='span-{{$orderDetail->id}}-{{$noPeriod}}' class='inline-block float-right'>
        <span title='Xác Nhận Trúng Thưởng' onclick="confirmFunctionSubmit(updateWinPrizeVietlott,[{{$orderDetail->id}},{{$noPeriod}},'{{config('laravelveso.winPrizeStatus.success.key')}}'],$message='Xác nhận?')" class="actionBtn bg-green-500 text-white cursor-pointer rounded p-0 px-1 inline-block  
         
        ">Xác Nhận</span>
        <span title="Hủy Trúng Thưởng" onclick="confirmFunctionSubmit(updateWinPrizeVietlott,[{{$orderDetail->id}},{{$noPeriod}},'{{config('laravelveso.winPrizeStatus.cancel.key')}}'],$message='Xác nhận?')"  class="actionBtn bg-red-500 text-white cursor-pointer rounded p-0 px-1 inline-block 
         
        ">Hủy KQ</span>
    </span>
    <input type="hidden" class='winPrizes' value="updateWinPrizeVietlott-{{$orderDetail->id}}-{{$noPeriod}}">
    @endcan 
<table class='w-full'>
    <tr>
        <td colspan="2">
        <img class='w-60 h-auto' id='img-formId-{{$orderDetail->id}}' src="{{isset($orderDetail->images[0])?asset('storage/'.$orderDetail->images[0]):''}}" alt=""/>
        </td>
    </tr>

    @if(!$showFunction && 
    Auth::user()->can('agency-updateOrderDetail',$orderDetail->orderDetail) ||  Auth::user()->can('admin-updateOrderDetail'))
        
        <form  method="POST" onsubmit="handleSubmitUploadFile('formId-{{$orderDetail->id}}')" id='formId-{{$orderDetail->id}}' enctype="multipart/form-data" action="javascript:void(0)" >
        <tr   
        class="
        @if(Auth::user()->role_id<3 && ($orderDetail->options['category']==config('laravelhtmldomparser.categoryType.traditionallottery.key')))
            hidden
        @endif
        ">
            <td>
                <input type="hidden" name='orderDetailId' value='{{$orderDetail->id}}'/>
                <input type="file" class='w-24 rounded' style='border:1px solid #d0d0d0 !important' name="file" placeholder="Choose File">
                <span class="text-danger">{{ $errors->first('file') }}</span></td>
            <td class='text-right'>
                <button type="submit" class="bg-yellow-500 text-white cursor-pointer rounded p-0 px-1 inline-block">Tải Lên</button>
            </td>
        </tr>
        </form>
    @endif
</table>    

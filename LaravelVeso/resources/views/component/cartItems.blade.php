<?php
use Phonglg\LaravelVeso\Helpers\ImageHelper;
?>

<div class=" "> 
    
    @if($errors->has('errForTickets')) 
        <p class='alert alert-danger'>{{$errors->first('errForTickets')}}</p>
    @endif

    <table class="table tableCart p-0">
        <tr class='listTable'> 
            <th>#</th> 
            <th>Thông tin Vé</th> 
            <th>SL</th> 
            <th class='text-center'>Hủy</th>
        </tr> 
        @foreach ($cart as $rowId=>$product)
        <tr style='border-top:4px solid #d0d0d0;'>
            <td class='p-0 pt-1 pl-1'> 
                <!-- if is traditional ticket -> show date_prize -->
                @if ($product->options['category']==config('laravelhtmldomparser.categoryType.traditionallottery.key'))
                    <?php $tempName=explode('|',$product->name)?>    
                    <img src="{{asset('/storage/photos/1/Provinces/'.$tempName[1].'.png')}}" alt="" class="w-16 md:w-20">  
                @else  <!-- for vietllot -->
                    <img src="{{ ImageHelper::showThumbImg(url($product->options['image'])) }}" alt="" class="w-16  md:w-20">
                @endif
 
            </td> 
            
            <td >
                <!-- err for out of date -->
                @if (isset($product->options['periodStatus']) && $product->options['periodStatus']==1 )
                <span class="text-red-500 mt-2 text-sm"> * Vé này đã hết hạn</span>
                @endif  
                
                <!-- if is traditional ticket -> show date_prize -->
                @if ($product->options['category']==config('laravelhtmldomparser.categoryType.traditionallottery.key'))
                    <?php $tempName=explode('|',$product->name)?>    
                    
                    <div class='w-full overflow-hidden'>
                        <p class='pt-1 float-left font-bold inline-block mb-0'>{{ $tempName[0] }}</p>
                        <p class='pt-1 inline-block float-left'>  &nbsp  
                        | {{ config('laravelhtmldomparser.categoryType.traditionallottery.gameType.'.$product->options['game_type'].'.name') }}
                            @if(isset($product->options['qtyRefund']) && $product->options['qtyRefund']>0)
                                | <i class="fas fa-gift text-blue-500"></i> <span class=''>{{$product->options['qtyRefund']}}</span>
                            @endif
                        </p> 
                    </div> 
                    <p>
                    {{ $data['provinces'][$tempName[1]] }} <span class='font-bold'>#{{ $product->options['prize_date'] }} </span> 
                    </p> 

                    <div class='w-full overflow-hidden'>
                        @if(isset($product->options['period']))
                            <p class='inline-block float-left'>
                            <!-- Kỳ vé: {{$product->options['period']}}. &nbsp  -->
                            </p>
                        @endif

                        @if(isset($product->options['agency']))
                            <p class='inline-block float-left'>
                            NCC: {{$product->options['agency']}}
                            </p>
                        @endif 
                    </div>


                    @if(isset($product->options['message']))
                        <span class='text-red-500'>{{$product->options['message']}}</span>
                    @endif
                    
                @else  <!-- for vietllot -->
                     
                    <p>
                        <span  class='font-bold ' >{{ $product->name }}</span> | 
                        <span class=''>
                        @if($product->options['category']!='keno')   
                            {{$data['methodsToPlay'][$product->options['methodSelected']]['name']}} 
                        @else
                            {{$data['methodsToPlayKeno'][$product->options['methodSelected']]['name']}} 
                        @endif
                        </span>
                    </p>
                @endif

                @include('laravelveso::component.itemDetail',['detail'=>$product->options]) 
            </td> 

            <td style='padding-right:0px'>
                <!-- not allow edit quantity -->
                @if ($product->options['category']==config('laravelhtmldomparser.categoryType.traditionallottery.key') &&
                    $product->options['game_type']!=config('laravelhtmldomparser.categoryType.traditionallottery.gameType.capnguyen.key'))
                    <form action="{{route('cart.update')}}" method="POST" class='hidden' enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" value="{{$rowId}}" name="rowId"> 
                        <input type="number" value="{{$product->qty}}" name="qty" class='qtyTicketInput border pl-1' > 
                        <button class="pl-1"><i class="fas fas fa-sync"></i></button>
                    </form> 

                    <div class="inline-block flex">
                        
                        <input type="button" onclick="updateQtyCart('{{$rowId}}',-1)" class="inline-block border bg-blue-500 text-white w-5 p-0" value='-'>
                        <input type="text" class="inline-block w-8 text-center border pointer-events-none" id='{{$rowId}}' value="{{$product->qty}}"  />
                        <input type="button" onclick="updateQtyCart('{{$rowId}}',1)" class="inline-block border bg-red-500 text-white w-5 p-0" value='+'>
                    </div>
                    
                    
                @else
                    {{$product->qty}} 
                @endif  
            </td>
            <td class='text-center'> 
                <form action="{{route('cart.delete')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("DELETE")
                    <input type="hidden" value="{{$rowId}}" name="rowId"> 
                    <button class="  "><i class="fas fa-trash-alt"></i></button>
                </form> 
            </td>
        </tr>
        <tr>
            <td  colspan="2">Tạm tính</td>
            <td colspan="2" class="text-right font-bold">
            {{number_format($product->price)}} đ
            </td>
        </tr>
        @endforeach

        @if(isset($data['refundTicktes']) && $data['refundTicktes'][0]>0)
            <tr><td colspan='4' >
            <i class="fas fa-gift"></i> Đại lý tặng 
                @if($data['refundTicktes'][1]>0){{$data['refundTicktes'][1]}} vé thường @endif 
                @if($data['refundTicktes'][2]>0){{$data['refundTicktes'][2]}} cặp nguyên @endif
            <span class='float-right font-bold'>-{{number_format($data['refundTicktes'][0])}}</span>
            </td></tr>
        @endif
        <tr>
            <td colspan='4' class='font-bold bg-gray-300'>Tổng cộng: <span class=' text-red-500 float-right inline-block text-xl'> {{number_format($data['total'])}}Đ</span></td>
            <input type='hidden' id='total' value="{{$data['total']}}"/>
        </tr>
    </table> 
    @include('laravelveso::component.scriptTotalTransfer',['id'=>'total','label'=>'tiền vé'])
</div> 
<?php 
use Phonglg\LaravelVeso\Helpers\Vietlott;
?>
@extends($template)

@section('content')
 
<div class="mx-auto">
     <h1 class="pagetitle">Danh sách trả thưởng</h1>
     @if(session('message'))
          <div class="alert alert-success">
               <p class="m-0">{{session('message')}}</p>
          </div>
     @endif 
      
     <!-- form -->
     <form action="{{$data['actionReport']}}" method="GET"  enctype="multipart/form-data" class='overflow-hidden p-2 mb-2 bg-gray-100'>
         @include('laravelveso::component.formFromToDate',['actionFrom'=>$data['actionReport'],'fromDate'=>date("d-m-Y", strtotime($data['invoiceStatistics']['fromDate'])),'toDate'=>date("d-m-Y", strtotime($data['invoiceStatistics']['toDate']))])  
         
         @if(Auth::user()->role_id<3)
            @include('laravellayout::componentsFilter.formSelect',['name'=>'ticketType','label'=>'Loại vé','listItem'=>$data['ticketTypes'],'keyValue'=>'keyValue','keyName'=>'keyName','selectedItem'=>$data['ticketType'],'message'=>($errors->has('ticketType'))?$errors->first('ticketType'):'','showAll'=>false,'classLabel'=>'w-5/12 md:w-4/12','classInput'=>'w-7/12 md:w-8/12 float-right'])

            @include('laravellayout::componentsFilter.formSelect',['name'=>'agency_id','label'=>'Đại lý','listItem'=>$data['agencies'],'keyValue'=>'id','keyName'=>'agency_name','selectedItem'=>$data['agency_id'],'message'=>($errors->has('agency_id'))?$errors->first('agency_id'):'','classLabel'=>'w-5/12 md:w-4/12','classInput'=>'w-7/12 md:w-8/12 float-right'])

         @endif

         <div  class='p-1 inline'>
            <button type="submit" class="bg-blue-500  p-1  text-white rounded-lg">Thống Kê</button>
        </div>  
    </form>

    <div  class='pb-2' id='totalPointTranfer'>

    </div>  
    <div class='pb-2'>
         Tổng số tiền đã thanh toán <span class='font-bold'> {{number_format($data['totalPointTranfer'])}}Đ</span>
    </div> 

    @include('laravelveso::adminOrder.compornentWinprize.listWinprize')
</div>
@include('laravelveso::adminOrder.componentOrder.scriptUpdateOrderDetail') 
@include('laravellayout::partial.popup.functionConfirm') 
@include('laravellayout::script.scriptCommasNumber',['idInputNumber'=>'point','stepNum'=>10000]) 
<script>
     function submitAllWinPrize(data){  
          var inputs = $(".winPrizes");
          let winPrizes=[];
          for(let i = 0; i < inputs.length; i++)
          winPrizes.push($(inputs[i]).val().split("-"));
          $('#totalPointTranfer').html('Đang thực hiện <span class="spinner-border text-danger w-5 h-5"></span>');
          // addClass
          $('.actionBtn').addClass('opacity-50 pointer-events-none')

          axios.post("{{$data['updateAllWinPrize']}}",{
            'winPrizes':winPrizes,'winPrizeStatus':data[0],'ticketType':'{{$data['ticketType']}}',
            })
            .then((response) => {   
                console.log(response);
                totalPointTranfer=0;
                for(let i=0;i<response['data'].length;i++){
                    if(response['data'][i].error) $(response['data'][i].idMsg).html('<span class="text-blue-500">'+response['data'][i].error+'</span>');
                    else{
                         if(response['data'][i].winPrizeStatus=='{{config('laravelveso.winPrizeStatus.success.key')}}') 
                              $(response['data'][i].idMsg).html('<span class="text-blue-500">Xác nhận Thành công </span>');
                         else $(response['data'][i].idMsg).html('<span class="text-blue-500">Hủy KQ Thành công </span>');
                         
                    }
                    if(response['data'][i].pointTranfer) totalPointTranfer+=parseInt(response['data'][i].pointTranfer);
                } 

                if(response['data'][0].winPrizeStatus=='{{config('laravelveso.winPrizeStatus.success.key')}}') 
                $('#totalPointTranfer').html('<span>Tổng số tiền Thanh toán: <span  class="font-bold">  ' +separatorNum(totalPointTranfer) +'Đ</span></span>');

                else  $('#totalPointTranfer').html('<span>Tổng số tiền hủy Thanh toán: <span  class="font-bold"> ' +separatorNum(totalPointTranfer) +'Đ</span></span>');
                //removeClass
                $('.actionBtn').removeClass('opacity-50 pointer-events-none')

            })
            .catch((error) => {
                 console.log('err:',error);
            }); 
  
     }
</script>
@endsection
 
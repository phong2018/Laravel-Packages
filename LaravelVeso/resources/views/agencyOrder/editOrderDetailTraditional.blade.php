@extends(config('laravelveso.layout'))

@section('content')
<div class="mx-auto">
     <h1 class="pagetitle">Khách hàng trúng thưởng</h1> 
     
     @if(session('message'))
          <div class="alert alert-success">
               <p class="m-0">{{session('message')}}</p>
          </div>
     @endif 
     
    <div colspan='4'>Khách hàng: <span class='text-red-500'>{{$data['customer']['info']}}</span></div>
    <div colspan='4'>TK Ngân hàng: {{$data['customer']['bank_info']}}</div>
     @include('laravelveso::adminOrder.componentOrder.traditionalDetail') 
     @include('laravellayout::partial.popup.functionConfirm') 
</div>
<script>
    // axios call updateWinPrize
    function updateWinPrize(data){   
        orderDetailId=data[0];
        noWin=data[1];
        axios.post("{{$data['updateWinPrize']}}",{
            'orderDetailId':orderDetailId,'noWin':noWin
            })
            .then((response) => {  
                console.log(response); 
                //location.reload();
            })
            .catch((error) => {
                 console.log(error);
            }); 
    } 
     // axios updateOrderDetail
     function updateOrderDetail(data){  
        orderDetailId=data[0];
        status=data[1];
        axios.post("{{ $data['updateOrderDetail'] }}",{
            'orderDetailId':orderDetailId,'status':status
            })
            .then((response) => {  
                console.log(response); 
                location.reload();
            })
            .catch((error) => {
                 console.log(error);
            }); 
    } 
    // axios getTicket to Return
    function getTicketToReturn(data,idRender){  
        axios.post("{{ $data['getTicketToReturn'] }}",{
            'orderDetailId':data[0], 
            'numberTickets':data[1],
            'noWinPrize':data[2],
            })
            .then((response) => {  
                console.log(response);  
                $('#'+idRender).html(response['data']);
            })
            .catch((error) => {
                 console.log(error);
            }); 
    } 
    // axios return ticket for Customer
    function returnTicketForCustomer(data,idRender){  
        axios.post("{{ $data['returnTicketForCustomer'] }}",{
            'orderDetailId':data[0],
            'numberTickets':data[1],
            'noWinPrize':data[2],
            'ticketId':data[3], 
            })
            .then((response) => {  
                console.log('YES');   
                $('#messageReturnTicket').html( '<span class="alert alert-danger block">'+response['data']['message']+'</span>' );
                // update newQtyTicket
                $newQtyTicket=parseInt($('#qtyTicket'+data[3]).text())-2;
                $('#qtyTicket'+data[3]).text($newQtyTicket);  
                $('#resultReturnTicket').html('Đã hoàn vé');
                $('#btnTicketToReturn').html('');
            })
            .catch((error) => {
                console.log('NOO');
                const errors = error.response.data.errors;
                const firstItem = Object.keys(errors)[0]; 
                const firstErrorMessage = errors[firstItem][0];
                console.log(firstItem,firstErrorMessage);
                $('#messageReturnTicket').html( '<span class="alert alert-danger block">'+firstErrorMessage+'</span>' );
            }); 
    } 
</script> 
@endsection
 
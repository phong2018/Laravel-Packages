
<div id='messageReturnTicket'></div>
<table class='table'>
<tr class='font-bold'><td>#</td><td>Vé Số</td><td>Số lượng</td><td>Ngày vé</td><td>Chọn</td></tr>
@foreach($tickets as $noTicket=>$ticket)
<tr><td>{{$noTicket}}</td><td class='font-bold'> {{$ticket->number}}</td><td><span id='qtyTicket{{$ticket->id}}'>{{$ticket->quantity}}</span></td><td>{{$ticket->prize_date}}</td><td><span onClick="returnTicketForCustomer([{{$data['orderDetailId']}},{{$data['numberTickets']}},{{$data['noWinPrize']}},{{$ticket->id}}],'idRender')" class="border p-1 rounded-md bg-blue-500 text-white cursor-pointer cursor-pointer text-white">Chọn</span></td></tr>
@endforeach
</table>
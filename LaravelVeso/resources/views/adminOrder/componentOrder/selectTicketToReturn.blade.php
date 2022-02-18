<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 
 
  <!-- Button to Open the Modal --> 
    <span  onClick="getTicketToReturn([{{$orderDetail->id}},{{$numberTickets}},{{$noWinPrize}}],'ticketsList')" class="bg-green-500 text-white cursor-pointer rounded p-0 px-1 inline-block cursor-pointer" id="btnTicketToReturn" data-toggle="modal" data-target="#selectTicketToReturn">
    Hoàn Vé
    </span>   

  <!-- The Modal -->
  <div class="modal" id="selectTicketToReturn">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title font-bold">Chọn Vé Để Hoàn Vé - Số lượng vé cần hoàn {{$numberTickets}} vé</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" id='ticketsList'>
          <span class="spinner-border text-primary inline-block"></span>
        </div> 
      </div>
    </div>
  </div>
 
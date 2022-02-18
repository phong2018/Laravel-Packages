

<div id="flipVesoProduct" class='cursor-pointer'><span class="border p-1 rounded">Báo Cáo Thống Kê <i class="fas fa-chevron-down text-xs pt-1 mb-2"></i></span> </div>
<div id="panelVesoProduct" class="mb-2 p-2 pb-1 border">
    <div class='overflow-hidden'> 
        <div class='w-full md:w-1/2 float-left'>
            <p class='pb-0  font-bold'>Vé Thường</span></p>
            <p class='pb-0'>Tổng số vé: <span class=' font-bold'>{{$data['reports']['vethuong']['qtyTicket']+$data['reports']['vethuong']['qtyTicketSoldOln']+$data['reports']['vethuong']['qtyTicketSoldDirect']}} vé</span></p>
            <p class='pb-0'>Còn lại: <span class=' font-bold'>{{$data['reports']['vethuong']['qtyTicket']}} vé</span></p>
            <p class='pb-0'>Bán Online: <span class=' font-bold'>{{$data['reports']['vethuong']['qtyTicketSoldOln']}} vé</span>  </p>
            <p class='pb-0'>Bán Trực tiếp: <span class=' font-bold'>{{$data['reports']['vethuong']['qtyTicketSoldDirect']}} vé</span>  </p>
            <p class='pb-2'>Doanh số: <span class=' font-bold'>{{number_format($data['reports']['vethuong']['totalTicketSoldDirect'])}}Đ</span>  </p>
        </div>
        <div class='w-full md:w-1/2 float-right'>
            <p class='pb-0  font-bold'>Cặp nguyên</span></p> 
            <p class='pb-0'>Tổng số vé: <span class=' font-bold'>{{$data['reports']['capnguyen']['qtyTicket']+$data['reports']['capnguyen']['qtyTicketSoldOln']+$data['reports']['capnguyen']['qtyTicketSoldDirect']}} vé</span></p>
            <p class='pb-0'>Còn lại: <span class=' font-bold'>{{$data['reports']['capnguyen']['qtyTicket']}} vé</span></p>
            <p class='pb-0'>Bán Online: <span class=' font-bold'>{{$data['reports']['capnguyen']['qtyTicketSoldOln']}} vé</span>  </p>
            <p class='pb-0'>Bán Trực tiếp: <span class=' font-bold'>{{$data['reports']['capnguyen']['qtyTicketSoldDirect']}} vé</span>  </p>
            <p class='pb-2'>Doanh số: <span class=' font-bold'>{{number_format($data['reports']['capnguyen']['totalTicketSoldDirect'])}}Đ</span>  </p>
        </div> 
    </div>
</div>
<style>
    #panelVesoProduct {display: none;}
</style>
<script> 
$(document).ready(function(){
  $("#flipVesoProduct").click(function(){
    $("#panelVesoProduct").slideToggle("slow");
  });
});
</script>
 
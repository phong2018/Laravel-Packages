<div id='totalTranfer'></div>
<script>
    var banksFee=<?php echo json_encode($data['banksFee']); ?>;
    function caculatetotalTranfer(){ 
        var point=$('#{{$id}}').val(); 
        point=strReplaceAll(point,",",'');
        point=parseFloat(point);
        var bank_code=$('#bank_code').val();
        var tranfersFee=0;
        var strTotal='';
        if(bank_code){
            tranfersFee=banksFee[bank_code][0]*point/100+banksFee[bank_code][1];
            tranfersFee=tranfersFee.toFixed(0);
            total=parseFloat(point)+parseFloat(tranfersFee);
            strTotal='<p  class="alert alert-danger">Tổng tiền cần thanh toán ='+separatorNum(point)+' ({{$label}}) + '+ separatorNum(tranfersFee)+ ' (phí chuyển) <span class="inline-block">= <strong class="text-red-500 font-bold">'+separatorNum(total)+'Đ</strong></span></p>';
        }
        $('#totalTranfer').html(strTotal);
    }

    $(document).ready(function(){
        $("#bank_code").change(function() {//alert(banksFee[this.value][0]);
            caculatetotalTranfer();
        });
        // when load pate
        caculatetotalTranfer();
    }); 
</script>
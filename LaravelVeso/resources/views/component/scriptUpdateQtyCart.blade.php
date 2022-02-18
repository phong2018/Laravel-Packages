<script> 
    function updateQtyCart(rowId,extraVal){
        let qty=$('#'+rowId).val();
        if(isNaN(qty)) qty=1;
        else qty=parseInt(qty) + parseInt(extraVal);
        if(qty<=0) qty=1;
        
        $('#'+rowId).val(qty);

        axios.post("{{$data['updateQtyCart']}}",{
            'rowId':rowId,'qty':qty
            })
            .then((response) => {  
                preQty=qty;
                location.reload();
                console.log(response);  
            })
            .catch((error) => {
                console.log(error);
            }); 
 
    }
</script>
<script>
    // axios call updateWinPrize traditional
    function updateWinPrizeTraditional(data){   
        console.log(data);
        $('#span-'+data[0]).addClass('opacity-50 pointer-events-none')
        orderDetailId=data[0]; 
        idMsg='#msg-'+orderDetailId;
        axios.post("{{$data['updateWinPrize']}}",{
            'orderDetailId':data[0],'winPrizeStatus':data[1],'idMsg':idMsg
            })
            .then((response) => {   
                idMsg=response['data']['idMsg'];
                winPrizeStatus=response['data']['winPrizeStatus'];
                //-------
                if(response['data']['error']) $(idMsg).html(response['data']['error']);
                else{
                    if(winPrizeStatus=='{{config('laravelveso.winPrizeStatus.success.key')}}') $(idMsg).html('<span class="text-blue-500">Xác nhận Thành công </span>'); 
                    else $(idMsg).html('<span class="text-blue-500">Hủy KQ Thành công</span>');
                }
            })
            .catch((error) => {
                 console.log('err:',error);
            }); 
    }

    // axios call updateWinPrize vietlott
    function updateWinPrizeVietlott(data){  
        console.log('updateWinPrizeVietlott',data);
        $('#span-'+data[0]+'-'+data[1]).addClass('opacity-50 pointer-events-none')
        idMsg='#msg-'+data[0]+'-'+data[1];

        axios.post("{{ $data['updateWinPrizeVietlott'] }}",{ 
                'orderDetailId':data[0],
                'noPeriod':data[1], 
                'winPrizeStatus':data[2],
                'idMsg':idMsg,
            })
            .then((response) => {  
                idMsg=response['data']['idMsg'];
                winPrizeStatus=response['data']['winPrizeStatus'];
                console.log(winPrizeStatus);
                //------- 
                if(winPrizeStatus=='{{config('laravelveso.winPrizeStatus.success.key')}}') $(idMsg).html('<span class="text-blue-500">Xác nhận Thành công </span>');
                else{
                    $(idMsg).html('<span class="text-blue-500">Hủy KQ Thành công</span>');
                }
            })
            .catch((error) => {
                console.log(error);
            }); 
         
    }
    // axios call cancel OrderDetail
    function updateOrderDetail(data){  
        orderDetailId=data[0];
        status=data[1];
        axios.post("{{ $data['updateOrderDetail'] }}",{
            'orderDetailId':orderDetailId,'status':status
            })
            .then((response) => {  
                console.log(response['data']); 
                if(response['data']['error']){
                    $('#mgsUpdate'+orderDetailId).html("<div class='alert alert-danger block'>"+response['data']['error']+"</div>");
                    
                }
                else {
                   location.reload();
                }
            })
            .catch((error) => {
                 console.log(error);
            }); 
    } 
</script>
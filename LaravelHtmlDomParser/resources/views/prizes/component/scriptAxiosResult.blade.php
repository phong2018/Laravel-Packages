<script>
    // axiosResultLottery
    function axiosResultLottery(typeResultLottery,isVietlottType=1){   
        axios.post("{{ $urlGetResultLottery }}",{
            'typeResultLottery':typeResultLottery,
            'isVietlottType':isVietlottType,//typePrize is Vietllot: 1
            })
            .then((response) => {  
                console.log(response);  
                // console.log('success');
                $("#liveResultLottery").html(response['data']);
            })
            .catch((error) => {
                 console.log(error);
            }); 
    } 
</script>
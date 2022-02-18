<script>
$(document).ready(function(){
  $("#prize_date").change(function(){
    //  alert($("#prize_date").val());
    axios.post("{{$data['getHtmlProvince']}}",{
        'prize_date':$("#prize_date").val()
        })
        .then((response) => {   
            $('#htmlProvince').html(response['data']);
        })  
        .catch((error) => {
            console.log(error);
        }); 
  });
});
</script>
<script>

// checkNumber
function checkNumber(number){ 
  let numbers=$('#numbers').val();
  let arrNumbers=numbers.split(";"); 
  for(let i=0;i<arrNumbers.length;i++)
  if(number==arrNumbers[i]) return 0;
  
  return 1;
}

 //Province Change
 function handleChangeFilter(){
    let numbers=$('#numbers').val();  

    if($("#province").val()!=''){ 
      $('#messageNumber').html('');
      if($("#numbers").val()!='')
      validNumbers('',numbers);
    } 
  } 

// removeNumber
function removeNumber(number){
  $("#"+number).remove(); 
  let numbers=$('#numbers').val(); 
  numbers=numbers.replace(number+';',''); 
  $('#numbers').val(numbers);  
}

function stringTicket(number,notValid=''){
  return "<span id='"+number+"' class='rounded mb-1 p-0 px-1 border bg-gray-200 mr-4 inline-block  "+notValid+"'>"+number+"<i onClick=\"removeNumber('"+number+"')\" class='cursor-pointer absolute ml-1 -mt-1 far fa-window-close'></i></span>";
}

// callvalideNumbers
function validNumbers(number,numbers){
  $('#loading').removeClass('hidden');
  axios.post("{{$data['urlValidNumber']}}",{
      'number':number,
      'numbers':numbers,
      'prize_date':$('#prize_date').val(),
      'province':$('#province').val(),
      'game_type':$('#game_type').val(),
      })
      .then((response) => {    
          $('#loading').addClass('hidden');
          if(number!=''){//add number
            if(response['data'][1]==0)
              $('#messageNumber').html('<span class="text-red-500 italic pb-2 block">Số này đã có trên hệ thống!</span>');
            else{
              $( "#showNumebers" ).append(stringTicket(number));
              let numbers=$('#numbers').val();
              $('#numbers').val(numbers+number+';')
              $('#messageNumber').html('');
            }

            $('#loading').addClass('hidden');
            
          }else{//change province
            $( "#showNumebers" ).html('');
            let existNotValid=false;
            for(i=0;i<response['data'].length;i++)
            if(response['data'][i][1]==1) $( "#showNumebers" ).append(stringTicket(response['data'][i][0],''));
            else{
              $( "#showNumebers" ).append(stringTicket(response['data'][i][0],'notValid'));
              existNotValid=true;
            }
            if(existNotValid) $('#messageNumber').html('<span class="text-red-500 italic pb-2 block">Cần xóa số không hợp lệ!</span>');
            $('#loading').addClass('hidden');
          }
          
      })  
      .catch((error) => {
        $('#loading').addClass('hidden');
        const errors = error.response.data.errors;
        const firstItem = Object.keys(errors)[0];
        const firstItemDOM = document.getElementById(firstItem);
        const firstErrorMessage = errors[firstItem][0];
        $('#messageNumber').html('<span class="text-red-500 italic pb-2 block">'+firstErrorMessage+'</span>');
          
      }); 
}
// number change
$(document).ready(function(){
  // numberChange
  $("#number").keyup(function(e){ 
    // if enter get number
    let number=$('#number').val();  
    if(e.keyCode == 13 && number!='') {      
      
      if(checkNumber(number)==0){
        $('#messageNumber').html('<span class="text-red-500 italic pb-2 block">Số này nhập rồi!</span>')
      }
      else validNumbers(number,'');
      
    } 
  });
  //Province Change
  $("#prize_date").change(function(e){  
    $('#messageNumber').html('<span class="text-red-500 italic pb-2 block">Cần chọn tỉnh</span>')
  });
  //gameType Change
  $("#game_type").change(function(e){  
    let gameType=$('#game_type').val(); 
    if(gameType=='capnguyen'){
      $('#quantity').val(1);
      $('#price').val(1100000);
    }
    else{
      $('#quantity').val(11);
      $('#price').val(10000);
    } 

    handleChangeFilter();
  });
});
 
 
// prevent submit when enter
$(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
  // show tickets when init
  if($("#numbers").val()!='') validNumbers('',$("#numbers").val());
});

</script>

<style>
  .notValid{
    border: 1px solid red !important;
  }
</style>
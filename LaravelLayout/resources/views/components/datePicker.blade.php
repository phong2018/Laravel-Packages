<script src="{{ asset('laravellayout/datePicker/jquery-ui.js') }}"></script>
<link href="{{ asset('laravellayout/datePicker/jquery-ui.css') }}" rel="stylesheet" />
<script>
var widthDatePicker=$('#colRight').width()-10;
</script>
 <input style='' type="text" id="datepicker2" value="" /> 
 <style>
   *:focus {
    outline: none;
   }
 </style>
<script>
$(function() {
  $("#datepicker2").datepicker({
    //showOn: both - datepicker will come clicking the input box as well as the calendar icon
    //showOn: button - datepicker will come only clicking the calendar icon
    showOn: 'both',
    //you can use your local path also eg. buttonImage: 'images/x_office_calendar.png'
    buttonImage: '',
    buttonImageOnly: false,
    changeMonth: true,
    changeYear: true,
    showAnim: 'slideDown',
    duration: 'fast',
    dateFormat: 'dd-mm-yy'
  });
 
  $(document).ready(function(){ 
    //document.getElementById("datepicker2").focus();
    $('#datepicker2').datepicker('show')
    $('#ui-datepicker-div').width(widthDatePicker);
  }); 
});
</script>
 

<script src="{{ asset('laravellayout/datePicker/jquery-ui.js') }}"></script>
<link href="{{ asset('laravellayout/datePicker/jquery-ui.css') }}" rel="stylesheet" />


  <div class='p-1  inline -mt-2'>
  Từ ngày: <input class='border pl-1 w-24'  type="text" name='fromDate' id="fromDate" value="{{$fromDate}}" />
  </div> 
  <div class='p-1  inline -mt-2'>
  Đến ngày: <input class='border pl-1 w-24' type="text" name='toDate' id="toDate" value="{{$toDate}}" />
  </div> 


<style>
#datepicker + .ui-datepicker-trigger {
    position:absolute; 
    margin-left:-18px;
    margin-top:2px;
} 
</style>
<script>
$(function() {
  $("#fromDate").datepicker({ 
    showOn: 'both', 
    buttonImage: 'http://jqueryui.com/resources/demos/datepicker/images/calendar.gif',
    buttonImageOnly: false,
    changeMonth: true,
    changeYear: true,
    showAnim: 'slideDown',
    duration: 'fast',
    dateFormat: 'dd-mm-yy'
  }); 
  $("#toDate").datepicker({ 
    showOn: 'both', 
    buttonImage: 'http://jqueryui.com/resources/demos/datepicker/images/calendar.gif',
    buttonImageOnly: false,
    changeMonth: true,
    changeYear: true,
    showAnim: 'slideDown',
    duration: 'fast',
    dateFormat: 'dd-mm-yy'
  }); 
});
</script>
 

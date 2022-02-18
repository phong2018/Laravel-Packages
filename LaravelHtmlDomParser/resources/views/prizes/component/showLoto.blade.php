<script> 
$(document).ready(function(){
  $("#flip-{{$prizes[0]['prize_date']}}").click(function(){
    $("#panel-{{$prizes[0]['prize_date']}}").slideToggle("slow");
  });
});
</script>
<style>  

#panel-{{$prizes[0]['prize_date']}} { 
  display: none;
}
</style>
 
<div class='text-center mt-3'>
<span colspan="{{count($prizes)+1}}" class='border bg-black text-white text-center cursor-pointer  p-1 rounded-md m-auto  '  id="flip-{{$prizes[0]['prize_date']}}" >
    Dò Loto {{$labelLoTo}} {{date("d/m/Y", strtotime($prizes[0]['prize_date']))}}
</span>
</div>

<div id="panel-{{$prizes[0]['prize_date']}}"> 
<table class="w-full border"> 
  <tbody>
    <tr class="bg-gray-300">  
      <td class='pl-1'>#</td>
      @for($i=count($prizes)-1;$i>=0;$i--)
        <td   class='border font-bold pl-1'> {{$prizes[$i]['province_name']}}</td>
      @endfor 
    </tr> 
    @for($i=0;$i<=9;$i++)
        <tr>
            <td class='border pl-1'>{{$i}}</td>
        @foreach($rowNumberLoto as $noRowNum => $rowNum)
            <td  class='border pl-1'>
                @if(isset($rowNum[$i]))
                    @foreach($rowNum[$i] as $num)
                        {!!$num!!}
                    @endforeach
                @else
                &nbsp
                @endif
            </td>
        @endforeach
        </tr> 
    @endfor
  </tbody>
</table>
</div>
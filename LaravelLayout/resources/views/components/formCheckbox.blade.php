<?php
if(!$selectedItem)$selectedItem=[];
if(!isset($classLabel)||$classLabel=='')$classLabel='w-2/12';
if(!isset($classInput)||$classInput=='')$classInput='w-10/12 float-right';
?>
<div class="mb-2 overflow-hidden">
    <label for="Permission"  class="{{$classLabel}}">{{$label}}</label><br> 
    
    <div class="{{$classInput}} rounded-lg overflow-auto h-56">
        @foreach($listItem as $key=>$item)
            <input 
            @if (in_array($item->$keyValue,$selectedItem))
                checked
            @endif
            value="{{$item->$keyValue}}" type="checkbox" name="{{$name}}"/> {{$item->$keyName}}<br>
        @endforeach
        <hr>
        <input onclick="checkAllCheckbox(true,'{{$name}}')" name='checkall' type="radio"/> Check All
        <input onclick="checkAllCheckbox(false,'{{$name}}')"  name='checkall' type="radio"/> UnCheck All
    </div>
</div> 
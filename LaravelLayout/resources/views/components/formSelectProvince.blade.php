<?php
if(!isset($classLabel)||$classLabel=='')$classLabel='w-2/12';
if(!isset($classInput)||$classInput=='')$classInput='w-10/12 float-right';
?>

<div class="mb-2 overflow-hidden">
    <label for="Permission"  class="{{$classLabel}}">{{$label}}</label> 
    
    <div class="{{$classInput}} rounded-lg">
        <select onchange="handleChangeFilter()" name="{{$name}}" id="{{$name}}" value="{{old($name)}}" class="form-control">
            <option value="">{{$label}}</option>    
            @foreach ($listItem as $item)
                <option value="{{$item->$keyValue}}" {{(old($name,$selectedItem)==$item->$keyValue)?'selected':''}}>{{$item->$keyName}}</option>  
            @endforeach
        </select>  

        @if (!empty($message)) 
            <div class="text-red-500 mt-2 text-sm">{{$message}}</div>
        @endif 
    </div>
</div> 
<?php
if(!isset($showAll)) $showAll=true;
?>
<div class='p-1  inline -mt-2'>
{{$label}}
<select class='w-24 inline-block' name="{{$name}}" id="{{$name}}" value="{{old($name)}}" class="form-control">
    @if($showAll)
    <option value="">Tất cả</option>    
    @endif
    @foreach ($listItem as $item)
        <option value="{{$item->$keyValue}}" {{(old($name,$selectedItem)==$item->$keyValue)?'selected':''}}>{{$item->$keyName}}</option>  
    @endforeach
</select>  
</div> 
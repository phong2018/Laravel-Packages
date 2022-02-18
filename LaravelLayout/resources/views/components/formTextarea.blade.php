<?php
if(!isset($classLabel)||$classLabel=='')$classLabel='w-2/12';
if(!isset($classInput)||$classInput=='')$classInput='w-10/12 float-right ';
?>
<div class="mb-2 overflow-hidden">
    @if (!empty($label)) 
        <label for="{{ $label }}" class="{{$classLabel}}" >{{ $label }}</label>
    @endif
    <div class="{{$classInput}} rounded-lg">
        <textarea name="{{$name}}"  id="{{$name}}" class="form-control
            @if (!empty($message)) 
            border-red-500
            @endif
            "  
            placeholder="{{$label}}" cols="30" rows="3">{{old($name,$value)}}</textarea>   
            @if (!empty($message)) 
                <div class="text-red-500 mt-2 text-sm">{{$message}}</div>
            @endif
    </div>
   
</div>


<?php
if(!isset($classLabel)||$classLabel=='')$classLabel='w-2/12';
if(!isset($classInput)||$classInput=='')$classInput='w-10/12 float-right';
?>
<div class="mb-2 overflow-hidden">
    @if (!empty($label)) 
        <label for="{{ $label }}" class="{{$classLabel}}" >{{ $label }}</label>
    @endif
    <div class="{{$classInput}} rounded-lg">
        <div class="input-group">
            <span class="input-group-btn">
            <a id="lfm-{{$name}}" data-input="{{$name}}" data-preview="holder-{{$name}}" class="btn btn-default border bg-gray-200 ">
                <i class="fa fa-picture-o"></i> Choose
            </a>
            </span>

            <input id="{{$name}}" value="{{old($name,$value)}}" class="form-control" type="text" name="{{$name}}">
            
        </div>
        <div id="holder-{{$name}}" style="margin-top:15px;max-height:100px;">
            @if (!empty($value)) 
                <img src="{{$value}}" style="height: 5rem;">
            @endif
        </div>
    </div>
    
</div>
<div class="mb-2 flex">
    <label for="{{ $label }}" class="w-2/12" ></label>
    @if (!empty($message)) 
        <div class="w-10/12 float-right text-red-500 text-sm">{{$message}}</div>
    @endif
</div>

<script>
    $('#lfm-{{$name}}').filemanager('image', {prefix: route_prefix}); 
</script>  
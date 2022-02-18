<?php
if(!isset($classLabel)||$classLabel=='')$classLabel='w-2/12';
if(!isset($classInput)||$classInput=='')$classInput='w-10/12 float-right';
if(!isset($required) )$required='';
?>

<div class="mb-2 overflow-hidden">
    @if (!empty($label) && ($type !== 'submit')) 
        <label for="Product description" class="{{$classLabel}}" >
            {{ $label }}
            @if($required) 
            <span class='text-red-500'>*</span>
            @endif
        </label>
    @endif
    <!-- ---------------------------- -->
    <div class="{{$classInput}} rounded-lg">
        @switch($type)

            @case('label')
                    <p class='bg-gray-200 form-control disabled'>{{old($name,$value)}}</p>
                    @break

            @case('text')
                <input type="{{$type}}" name="{{$name}}"  id="{{$name}}" class="form-control
                    @if (!empty($message)) 
                    border-red-500
                    @endif
                    " 
                    placeholder="{{$label}}" 
                    value="{{old($name,$value)}}"  
                    /> 
                    @break

            @case('date')
                <input type="{{$type}}" name="{{$name}}"  id="{{$name}}" class="form-control
                    @if (!empty($message)) 
                    border-red-500
                    @endif
                    " 
                    placeholder="{{$label}}" 
                    value="{{old($name,$value)}}"  
                    /> 
                    @break

            @case('number')
                <input type="{{$type}}" name="{{$name}}" step="1"  id="{{$name}}" class="form-control
                    @if (!empty($message)) 
                    border-red-500
                    @endif
                    " 
                    placeholder="{{$label}}" 
                    value="{{old($name,$value)}}"/> 
                    @break
            
            @case('file')
                <input type="{{$type}}" name="{{$name}}" id="{{$name}}" class="form-control
                    @if (!empty($message)) 
                    border-red-500
                    @endif
                    " 
                    placeholder="{{$label}}" 
                    value="{{old($name,$value)}}" />
                    @break

            @case('password')
                    <input type="{{$type}}" name="{{$name}}"  id="{{$name}}" class="form-control
                    @if (!empty($message)) 
                    border-red-500
                    @endif
                    "  
                    autocomplete="false"
                    placeholder="Password"
                    /> 
                    @break

            @case('password_confirmation')
                    <input type="password" name="{{$name}}"  id="{{$name}}" class="form-control
                    @if (!empty($message)) 
                    border-red-500
                    @endif
                    "  
                    placeholder="Repeate Password"
                    autocomplete="false"
                    />   
                    @break
                    
            @case('submit') 
                    <button type="submit" class="bg-blue-500 w-24 p-2 text-white rounded-lg {{$classLabel }}">{{$label}}</button>
                    @break
        @endswitch
        <!-- ---------------------------- -->
        @if (!empty($message)) 
            <div class="text-red-500 mt-2 text-sm">{{$message}}</div>
        @endif
    </div>
</div>
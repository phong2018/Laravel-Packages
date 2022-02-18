<?php
if(!$selectedItem)$selectedItem=[];
?>

<div class="mb-2 flex">
    <label for="Permission" class="w-2/12" >Permission</label><br>
    <div class="w-10/12 rounded-lg overflow-auto h-96 ">
        @foreach ($permissionsForRole as $model=>$role) 
            <hr>
            {{$role['label']}} <br>
            @foreach ($role['permissions'] as $keyPermisstion=>$permission)
                <input 
                @if (in_array($model.':'.$keyPermisstion,$selectedItem))
                    checked
                @endif
                value="{{$model}}:{{$keyPermisstion}}" type="checkbox" name="permissions[]"/>  {{$permission}} <br>
            @endforeach
        @endforeach
        <hr>
        <input onclick="checkAllCheckbox(true,'permissions[]')" name='checkall' type="radio"/> Check All
        <input onclick="checkAllCheckbox(false,'permissions[]')"  name='checkall' type="radio"/> UnCheck All
    </div> 
</div> 




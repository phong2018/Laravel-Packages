<?php
if(!isset($classLabel)||$classLabel=='')$classLabel='w-2/12';
if(!isset($classInput)||$classInput=='')$classInput='w-10/12 float-right';
?>
<div class="mb-2 overflow-hidden">
    @if (!empty($label)) 
        <label for="{{ $label }}" class="{{$classLabel}}">{{ $label }}</label>
    @endif
    <div class="{{$classInput}} rounded-lg">
        <textarea name="{{$name}}"  id="{{$name}}" lass="
            @if (!empty($message)) 
            border-red-500
            @endif
            "  
            placeholder="{{$label}}" cols="30" rows="10">{{old($name,$value)}}</textarea>   

        @if (!empty($message)) 
            <div class="text-red-500 mt-2 text-sm">{{$message}}</div>
        @endif
    </div>
</div>

<script>
    // https://ckeditor.com/latest/samples/old/toolbar/toolbar.html
    $('textarea[name={{$name}}]').ckeditor({
        height: 400,
        width:'100%',
        toolbarGroups    : [ 
            { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
            { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
            { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
            { name: 'forms' },
            '/',
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
            { name: 'links' },
            { name: 'insert' },
            '/',
            { name: 'styles' },
            { name: 'colors' },
            { name: 'tools' },
            { name: 'others' },
            { name: 'about' }
      ],
        filebrowserImageBrowseUrl: route_prefix + '?type=Images',
        filebrowserImageUploadUrl: route_prefix + '/upload?type=Images&_token={{csrf_token()}}',
        filebrowserBrowseUrl: route_prefix + '?type=Files',
        filebrowserUploadUrl: route_prefix + '/upload?type=Files&_token={{csrf_token()}}'
    });
</script>
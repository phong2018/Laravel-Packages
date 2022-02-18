@extends(config('laravelveso.printing'))
@section('content')
<table class='printing table'>
    <tr>
        @for($i=0;$i<$numberPrint/2;$i++)
        <td
        @if($i>0)
            style='padding:0px 0px 5px 5px;'
            @else 
            style='padding-bottom:5px;'
            @endif
            >
            @include('laravelveso::printing.component.miennam') 
            </td>
        @endfor
    <tr>
    @if($numberPrint>1)
    <tr>
        @for($i=0;$i<$numberPrint/2;$i++)
        <td
        @if($i>0)
            style='padding:0px 0px 5px 5px;'
            @else 
            style='padding-bottom:5px;'
            @endif
            >
            @include('laravelveso::printing.component.miennam') 
            </td>
        @endfor
    <tr>
    @endif
</table>

@include('laravelveso::printing.component.styles'.$numberPrint.'.miennam') 
 
<script>
     window.print();
</script>
@endsection
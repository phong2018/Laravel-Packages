@extends(config('laravelveso.printing'))
@section('content')
<table class='printing table'>
<tr>
        @for($i=0;$i<$numberPrint/2;$i++)
            <td>
            @include('laravelveso::printing.component.max3d') 
            </td>
        @endfor
    <tr>
    @if($numberPrint>1)
    <tr>
        @for($i=0;$i<$numberPrint/2;$i++)
            <td>
            @include('laravelveso::printing.component.max3d') 
            </td>
        @endfor
    <tr>
    @endif
</table>
@include('laravelveso::printing.component.styles'.$numberPrint.'.max3d') 
<script>
     window.print();
</script>
@endsection
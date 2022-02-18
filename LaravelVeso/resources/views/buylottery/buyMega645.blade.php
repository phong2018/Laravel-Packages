@extends(config('laravelveso.layout'))

@section('content')
<link href="{{ asset('packages/css/sass/buylottery.css') }}" rel="stylesheet">
<script> 
var data=<?php echo json_encode($data); ?>;
</script> 
<div id="{{$data['vietlottType']['key']}}" class='buyVietlott'></div>
<script src="{{ asset('packages/js/react/vietlott/buyMega645.js') }}"></script>
@endsection
 
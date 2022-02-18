@extends(config('laravelveso.layout'))

@section('content')
<link href="{{ asset('packages/css/sass/buylottery.css') }}" rel="stylesheet">
<script> 
var data=<?php echo json_encode($data); ?>;
console.log(data);
</script>
<div id="buyTicket"></div>
<script src="{{ asset('packages/js/react/traditionalTicket/buyTicket.js') }}"></script>
@endsection
 
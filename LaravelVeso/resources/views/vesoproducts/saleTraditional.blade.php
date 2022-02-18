@extends(config('laravelveso.layoutFull'))
@section('content') 
<script> var data=<?php echo json_encode($data); ?>;</script>
<div id="saleTraditional" class='w-full'></div>
<script src="{{ asset('packages/js/react/traditionalTicket/saleTraditional.js') }}"></script>
@endsection
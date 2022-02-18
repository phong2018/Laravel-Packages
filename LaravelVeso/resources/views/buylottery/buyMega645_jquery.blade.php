@extends(config('laravelveso.layout'))

@section('content')
<link href="{{ asset('packages/css/sass/buylottery.css') }}" rel="stylesheet">
<script> 
var methodsToPlay=<?php echo json_encode($methodsToPlay); ?>;
</script>
<div class="mx-auto">
     <h1 class="pagetitle">Product List</h1>

     @if(session('message'))
          <div class="alert alert-success">
               <p class="m-0">{{session('message')}}</p>
          </div>
     @endif

     <div class="buyVietlott">
          <div class='vietlottOption flex'>
               <div id='methodsToPlay'>
                    @include('laravelveso::buylottery.component.methodsToPlay',['methodsToPlay'=>$methodsToPlay])
               </div>
               <div id='buyingPeriods'>
                    @include('laravelveso::buylottery.component.buyingPeriods',['buyingPeriods'=>$buyingPeriods])
               </div>
          </div>
          <div class='vietlotboso'>
               <div id='blockNumber1' class='blockNumber'>Bloc1</div>
               <div id='blockNumber2' class='blockNumber'>Bloc1</div>
               <div id='blockNumber3' class='blockNumber'>Bloc1</div>
               <div id='blockNumber4' class='blockNumber'>Bloc1</div>
               <div id='blockNumber5' class='blockNumber'>Bloc1</div>
               <div id='blockNumber6' class='blockNumber'>Bloc1</div>
          </div>
          <div class='tempTotal'>tempTotal</div>
          <div class='actionCart'>
               actionCart
          </div>
     </div>
</div> 
<script>
     getBallForEveryBlock(6);// init is 6ball for everyblock
</script>
@endsection
 
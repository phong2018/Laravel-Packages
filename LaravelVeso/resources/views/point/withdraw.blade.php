@extends(config('laravelveso.layoutAgency'))

@section('content')
<div class="mx-auto">
    <h1 class="pagetitle">Rút tiền từ ví</h3>
     @if(session('message'))
          <div class="alert alert-success">
               <p class="m-0">{{session('message')}}</p>
          </div>
     @endif

     <div class="bg-white md:bg-white md:flex"> 

        <div class="w-full">  

            <form action="{{route('point.withdraw.store')}}" method="POST" enctype="multipart/form-data" class='overflow-hidden'>
                @csrf
                
                <x-laravelcomponent-forminput name="point" classLabel='w-4/12 md:w-3/12' classInput='viewCommasNumber w-full md:w-full float-right'  value="{{old('point','10,000')}}" label="Số tiền rút(*)" type="text" message="{{($errors->has('point'))?$errors->first('point'):''}}" />    
                    
                @include('laravellayout::components.formTextarea',['name'=>'notes','classLabel'=>'hidden w-4/12 md:w-3/12','classInput'=>'w-full md:w-full float-right', 'value'=>old('notes'),'label'=>'Ghi chú','message'=>($errors->has('notes'))?$errors->first('notes'):''])
 
                <button type="submit" class="bg-blue-500 w-30 p-2 text-white rounded-lg float-right">Gửi yêu cầu</button>
        
            </form>
        </div>
    </div>
</div> 
@include('laravellayout::script.scriptCommasNumber',['idInputNumber'=>'point','stepNum'=>10000]) 
@endsection
 
@extends(config('laravelveso.layout'))

@section('content')
<div class="mx-auto">
    <h1 class="pagetitle">Nạp tiền vào ví</h3>
     @if(session('message'))
          <div class="alert alert-success">
               <p class="m-0">{{session('message')}}</p>
          </div>
     @endif

     <div class="bg-white md:bg-white md:flex"> 

        <div class="w-full">  

            <form action="{{route('point.store')}}" method="POST" enctype="multipart/form-data" class='overflow-hidden'>
                @csrf
                
                <x-laravelcomponent-forminput name="point" classLabel='w-4/12 md:w-3/12' classInput='viewCommasNumber w-full md:w-full float-right'  value="{{old('point','10,000')}}" label="Số tiền nạp(*)" type="text" message="{{($errors->has('point'))?$errors->first('point'):''}}" />  

                @include('laravellayout::components.formSelect',['name'=>'bank_code','classLabel'=>'hidden w-4/12 md:w-3/12','classInput'=>'w-full md:w-full float-right', 'label'=>'Chọn ngân hàng','listItem'=>$data['banks'],'keyValue'=>'id','keyName'=>'name','selectedItem'=>[],'message'=>($errors->has('bank_code'))?$errors->first('bank_code'):''])
                
                @include('laravellayout::components.formTextarea',['name'=>'notes','classLabel'=>'hidden w-4/12 md:w-3/12','classInput'=>'w-full md:w-full float-right', 'value'=>old('notes'),'label'=>'Ghi chú','message'=>($errors->has('notes'))?$errors->first('notes'):''])

                @include('laravelveso::component.scriptTotalTransfer',['id'=>'point','label'=>'tiền nạp'])
                
                <button type="submit" class="bg-blue-500 w-30 p-2 text-white rounded-lg float-right">Thanh Toán</button>
        
            </form>
        </div>
    </div>
</div> 
@include('laravellayout::script.scriptCommasNumber',['idInputNumber'=>'point','stepNum'=>10000]) 
<script>
    $(document).ready(function(){
        $('#point').on('keyup',function(){
            caculatetotalTranfer();
        });
    });
</script>
@endsection
 
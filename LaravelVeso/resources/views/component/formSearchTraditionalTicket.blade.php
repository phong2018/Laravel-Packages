<form action="{{ route('buyLottery.buyTraditionalLottery') }}" method="GET"  enctype="multipart/form-data" class='w-11/12 md:w-9/12 m-auto pb-2 overflow-hidden'>
    
    <div class='w-10/12 inline-block float-left pl-4'>
        <x-laravelcomponent-forminput name="numFilter" classLabel='w-4/12 md:w-3/12 hidden' classInput=' w-full md:w-full float-left'  value="{{old('numFilter',$numFilter)}}" label="Tìm số" type="number" message="{{($errors->has('numFilter'))?$errors->first('numFilter'):''}}" />  
    </div>
    <div  class='w-2/12 inline-block float-right pl-1'>
        <button type="submit" class="bg-blue-500 w-10 p-1 mt-1 text-white rounded-lg float-left"><i class="fas fa-search"></i></button>
    </div> 
</form>
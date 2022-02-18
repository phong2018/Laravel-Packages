@extends($template)
@section('content')
<!-- use for upload image in ckEditor -->
@include('laravellayout::partial.editor.CkEditor')
<!-- use for udload image by alone button -->
<script>{!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/stand-alone-button.js')) !!}</script>

<div class="md:w-full">
    <h1 class="pagetitle">Tạo Vé số</h1>
    <form action="{{ route('vesoproducts.store') }}" id="formAddTickets" method="post" enctype="multipart/form-data">
        @csrf
        <div class='w-full md:w-1/2 float-left pl-2 overflow-hidden cellInput'>
            <x-laravelcomponent-forminput classLabel='w-5/12 md:w-4/12' classInput='w-7/12 md:w-8/12 float-right' name="prize_date" value="{{old('prize_date',date('Y-m-d'))}}" label="Ngày" type="date" message="{{($errors->has('prize_date'))?$errors->first('prize_date'):''}}" />
        </div> 
      
        <div class='w-full md:w-1/2 float-left pl-2 overflow-hidden cellInput'>
            <x-laravelcomponent-forminput classLabel='w-5/12 md:w-4/12' classInput='w-7/12 md:w-8/12 float-right' type="number" name="quantity" value="{{old('quantity',11)}}" label="Số lượng"  message="{{($errors->has('quantity'))?$errors->first('quantity'):''}}" />
        </div>
        <div class='w-full md:w-1/2 float-left pl-2 overflow-hidden cellInput'>
            @include('laravellayout::components.formSelect',['name'=>'status','label'=>'Status','listItem'=>$status,'keyValue'=>'keyValue','keyName'=>'keyName','selectedItem'=>1,'message'=>($errors->has('status'))?$errors->first('status'):'','classLabel'=>'w-5/12 md:w-4/12','classInput'=>'w-7/12 md:w-8/12 float-right'])
        </div>
        <div class='w-full md:w-1/2 float-left pl-2 overflow-hidden cellInput'>
            @include('laravellayout::components.formSelect',['name'=>'game_type','label'=>'Cách chơi','listItem'=>$data['gameTypes'],'keyValue'=>'key','keyName'=>'name','selectedItem'=>config('laravelhtmldomparser.categoryType.traditionallottery.gameType.vethuong.key'),'message'=>($errors->has('game_type'))?$errors->first('game_type'):'','classLabel'=>'w-5/12 md:w-4/12','classInput'=>'w-7/12 md:w-8/12 float-right'])
        </div>
        <div class='w-full md:w-1/2 float-left pl-2 overflow-hidden cellInput'>
            <x-laravelcomponent-forminput classLabel='w-5/12 md:w-4/12' classInput='w-7/12 md:w-8/12 float-right' type="number" name="price" value="{{old('price',10000)}}" label="Giá"  message="{{($errors->has('price'))?$errors->first('price'):''}}" />
        </div> 

        <div class='w-full md:w-1/2 float-left pl-2 overflow-hidden cellInput'>
            <span id='htmlProvince'>
            @include('laravellayout::components.formSelectProvince',['name'=>'province','label'=>'Chọn tỉnh','listItem'=>$provinces,'keyValue'=>'slug','keyName'=>'name','selectedItem'=>[],'message'=>($errors->has('province'))?$errors->first('province'):'','classLabel'=>'w-5/12 md:w-4/12','classInput'=>'w-7/12 md:w-8/12 float-right'])
            </span> 
        </div>

        <div class='w-full md:w-1/2 float-left pl-2 overflow-hidden cellInput'>
            <x-laravelcomponent-forminput classLabel='w-5/12 md:w-4/12' classInput='w-7/12 md:w-8/12 float-right' name="period" value="{{old('period')}}" label="Kỳ Vé" type="text" message="{{($errors->has('period'))?$errors->first('period'):''}}" />
        </div>

        <div class='w-full md:w-1/2 float-left pl-2 overflow-hidden'>
            <x-laravelcomponent-forminput classLabel='w-5/12 md:w-4/12' classInput='w-7/12 md:w-8/12 float-right' name="number" value="{{old('number')}}" label="Nhập số" type="text" message="{{($errors->has('number'))?$errors->first('number'):''}}" />
            <div id='loading' class="hidden spinner-border"></div>
            <span id='messageNumber'></span>
            <span id='showNumebers'></span>
            <input type="hidden" value="{{old('numbers','')}}" name="numbers" id="numbers"/>
            @if($errors->has('numbers'))
                <div class="text-red-500 mt-2 text-sm">Chưa nhập số vé!</div>
            @endif
        </div> 
        
        <div class='w-full overflow-hidden pl-2 pt-2'> 
            <input type="submit" class="bg-blue-500 w-24 p-2 text-white rounded-lg" value='Save'/>
        </div>  
    </form> 
</div>   

@include('laravelveso::vesoproducts.components.scriptHtmlProvince')

@include('laravelveso::vesoproducts.components.scriptHandleAddNumber')

@endsection
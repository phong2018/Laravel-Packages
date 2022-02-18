
<?php
use Phonglg\LaravelVeso\Helpers\ImageHelper;
?>

@extends($template)
@section('content')
<!-- use for upload image in ckEditor -->
@include('laravellayout::partial.editor.CkEditor')
<!-- use for udload image by alone button -->
<script>{!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/stand-alone-button.js')) !!}</script>

<div class="md:w-full">
    <h1 class="pagetitle">Sửa Vé số</h1>

    @if(session('message')) 
        <div class="alert alert-success"><p class='m-0'>{{session('message')}}</p></div>    
    @endif

    @if(session('error')) 
        <div class="alert alert-danger"><p class='m-0'>{{session('error')}}</p></div>    
    @endif

    <form action="{{ route('vesoproducts.update',['vesoproduct'=>$vesoproduct]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT') 
        <div class='w-full md:w-1/2 float-left pl-2 overflow-hidden  cellInput'>
            <x-laravelcomponent-forminput classLabel='w-5/12 md:w-4/12' classInput='w-7/12 md:w-8/12 float-right' name="prize_date" value="{{old('prize_date',$vesoproduct['prize_date'])}}" label="Ngày" type="date" message="{{($errors->has('prize_date'))?$errors->first('prize_date'):''}}" />
        </div>  

        <div class='w-full md:w-1/2 float-left pl-2 overflow-hidden  cellInput'>
            <x-laravelcomponent-forminput classLabel='w-5/12 md:w-4/12' classInput='w-7/12 md:w-8/12 float-right' type="number" name="quantity" value="{{old('price',$vesoproduct['quantity'])}}" label="Số lượng"  message="{{($errors->has('quantity'))?$errors->first('quantity'):''}}" />
        </div>

         
        <div class='w-full md:w-1/2 float-left pl-2 overflow-hidden  cellInput'>
            @include('laravellayout::components.formSelect',['name'=>'status','label'=>'Status','listItem'=>$status,'keyValue'=>'keyValue','keyName'=>'keyName','selectedItem'=>$vesoproduct['status'],'message'=>($errors->has('status'))?$errors->first('status'):'','classLabel'=>'w-5/12 md:w-4/12','classInput'=>'w-7/12 md:w-8/12 float-right'])
        </div>
        <div class='w-full md:w-1/2 float-left pl-2 overflow-hidden  cellInput'>
            @include('laravellayout::components.formSelect',['name'=>'game_type','label'=>'Cách chơi','listItem'=>$data['gameTypes'],'keyValue'=>'key','keyName'=>'name','selectedItem'=>$vesoproduct['game_type'],'message'=>($errors->has('game_type'))?$errors->first('game_type'):'','classLabel'=>'w-5/12 md:w-4/12','classInput'=>'w-7/12 md:w-8/12 float-right'])
        </div>

       

        <div class='w-full md:w-1/2 float-left pl-2 overflow-hidden  cellInput'>
            <x-laravelcomponent-forminput classLabel='w-5/12 md:w-4/12' classInput='w-7/12 md:w-8/12 float-right' type="number" name="price" value="{{old('price',$vesoproduct['price'])}}" label="Giá"  message="{{($errors->has('price'))?$errors->first('price'):''}}" />
        </div>

        <div class='w-full md:w-1/2 float-left pl-2 overflow-hidden  cellInput'>
        <span id='htmlProvince'>
            @include('laravellayout::components.formSelect',['name'=>'province','label'=>'Chọn tỉnh','listItem'=>$provinces,'keyValue'=>'slug','keyName'=>'name','selectedItem'=>$vesoproduct['province'].'|'.$vesoproduct['category'],'message'=>($errors->has('province'))?$errors->first('province'):'','classLabel'=>'w-5/12 md:w-4/12','classInput'=>'w-7/12 md:w-8/12 float-right'])
        </span>
        </div>

        <div class='w-full md:w-1/2 float-left pl-2 overflow-hidden  cellInput'>
            <x-laravelcomponent-forminput classLabel='w-5/12 md:w-4/12' classInput='w-7/12 md:w-8/12 float-right' name="period" value="{{old('period',$vesoproduct['period'])}}" label="Kỳ Vé" type="text" message="{{($errors->has('period'))?$errors->first('period'):''}}" />
        </div>
        
        <div class='w-full md:w-1/2 float-left pl-2 overflow-hidden  cellInput'>
            <x-laravelcomponent-forminput classLabel='w-5/12 md:w-4/12' classInput='w-7/12 md:w-8/12 float-right' name="number" value="{{old('number',$vesoproduct['number'])}}" label="Nhập số" type="text" message="{{($errors->has('number'))?$errors->first('number'):''}}" />
        </div>

        <div class='w-full overflow-hidden pl-2 pt-2'> 
            <input type="submit" class="bg-blue-500 w-24 p-2 text-white rounded-lg" value='Save'/>
        </div>  
    </form> 
</div>  

@include('laravelveso::vesoproducts.components.scriptHtmlProvince')

@endsection
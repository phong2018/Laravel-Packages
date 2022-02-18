
@extends($data['template'])

@section('content')

<div class="md:w-full">
    <h1 class="pagetitle">Thông Tin</h1>
   
    @if(session('message')) 
        <div class="alert alert-success"><p class='m-0'>{{session('message')}}</p></div>    
    @endif

    @if(session('error')) 
        <div class="alert alert-danger"><p class='m-0'>{{session('error')}}</p></div>    
    @endif

    <form action="{{ route('account.update') }}" method="post">
        @csrf
        @method("PUT")
 
        <x-laravelcomponent-forminput classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'  name="username" value="{{$user['username']}}" label="Số điện thoại" type="label" message="" /> 

        <x-laravelcomponent-forminput classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'  name="point" value="{{number_format($user['point'])}}Đ" label="Tiền trong ví" type="label" message="" /> 

        <x-laravelcomponent-forminput classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'  name="point" value="{{number_format($user['accumulate_point'])}}Đ" label="Điểm tích lũy" type="label" message="" /> 

        <x-laravelcomponent-forminput classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'  name="refundsTicket" value="{{$data['refundTickets'][0]}} Vé thường & {{$data['refundTickets'][1]}} cặp nguyên" label="Vé được tặng" type="label" message="" /> 

        <x-laravelcomponent-forminput classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'  name="name" value="{{old('name',$user['name'])}}" label="Họ tên" type="text" message="{{($errors->has('name'))?$errors->first('name'):''}}" /> 

        <x-laravelcomponent-forminput classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'  name="identity_card_number" value="{{old('name',$user['identity_card_number'])}}" label="CMND" type="text" message="{{($errors->has('identity_card_number'))?$errors->first('identity_card_number'):''}}" /> 

        <x-laravelcomponent-forminput classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'  name="email" value="{{old('email',$user['email'])}}" label="Email" type="text" message="{{($errors->has('email'))?$errors->first('email'):''}}" /> 
        
        @if(strpos($user['email'],'temp_email-') !== false)
        <p class='text-red-500 text-right -mt-2 mb-2'>* Bạn cần chỉnh sửa lại đúng email của bạn!</p> 
        @endif

        @include('laravellayout::components.formTextarea',['name'=>'bank_info','classLabel'=>'w-4/12 md:w-3/12','classInput'=>'w-8/12 md:w-9/12 float-right', 'value'=>old('bank_info',$user['bank_info']),'label'=>'TK Ngân hàng','message'=>($errors->has('bank_info'))?$errors->first('bank_info'):'']) 

        <x-laravelcomponent-forminput classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'  name="password" value="" label="Đổi MK" type="password" message="{{($errors->has('password'))?$errors->first('password'):''}}" />

        <x-laravelcomponent-forminput classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'  name="password_confirmation" value="" label="Nhập lại MK" type="password_confirmation" message="" />

        <x-laravelcomponent-forminput classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'  name="old_password" value="" label="MK cũ" type="password" message="{{($errors->has('old_password'))?$errors->first('old_password'):''}}" />

        @if($user['role_id']==config('laraveluserrole.defaultAgencyRoleId'))
            @include('laravelveso::lotteryAgency.lotteryAgencyInfo')
        @endif
        
        <button type="submit" class="bg-blue-500 w-24 p-2 text-white rounded-lg">Lưu Lại</button>
  
    </form>



</div> 
@endsection
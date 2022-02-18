<div class="md:w-full">  
    <form action="{{route('order.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        

        <x-laravelcomponent-forminput name="fullname" value="{{old('fullname')}}" label="Fullname" type="text" message="{{($errors->has('fullname'))?$errors->first('fullname'):''}}" />

        <x-laravelcomponent-forminput name="address" value="{{old('address')}}" label="Address" type="text" message="{{($errors->has('address'))?$errors->first('address'):''}}" />

        <x-laravelcomponent-forminput name="city" value="{{old('city')}}" label="City" type="text" message="{{($errors->has('city'))?$errors->first('city'):''}}" />

        <x-laravelcomponent-forminput name="country" value="{{old('country')}}" label="Country" type="text" message="{{($errors->has('country'))?$errors->first('country'):''}}" />

        <x-laravelcomponent-forminput name="post_code" value="{{old('post_code')}}" label="Post code" type="text" message="{{($errors->has('post_code'))?$errors->first('post_code'):''}}" />

        <x-laravelcomponent-forminput name="phone_number" value="{{old('phone_number')}}" label="Phone number" type="text" message="{{($errors->has('phone_number'))?$errors->first('phone_number'):''}}" />     

        @include('laravellayout::components.formTextarea',['name'=>'notes','value'=>old('notes'),'label'=>'Notes','message'=>($errors->has('notes'))?$errors->first('notes'):''])
 
        <x-laravelcomponent-forminput type="submit" name="" value="" label="Checkout"  message="" />
  
    </form>
</div> 
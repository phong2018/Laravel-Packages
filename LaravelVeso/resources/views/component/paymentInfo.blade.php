<div class="md:w-full">  
    <h4 class='pb-2 font-bold'>Thông tin khách hàng</h4>
    
    <form id='formCheckout' action="{{route('order.store')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name='errForTickets' />
        <!-- err in \views\component\cartItems.blade.php  -->
        
        <x-laravelcomponent-forminput name="name" classInput='w-full' classLabel='w-full hidden' value="{{old('name', isset($data['customer'])?$data['customer']->name:'')}}" label="Họ tên(*)" type="text" message="{{($errors->has('name'))?$errors->first('name'):''}}" /> 
            
        <x-laravelcomponent-forminput name="phone_number" classInput='w-full' classLabel='w-full hidden' value="{{old('phone_number',isset($data['customer'])?$data['customer']->username:'')}}" label="SĐT(*)" type="text" message="{{($errors->has('phone_number'))?$errors->first('phone_number'):''}}" />      
        
        <h4 class='pb-0 font-bold mb-2'>Chọn phương thức thanh toán</h4>
        
        @include('laravellayout::components.formSelect',['name'=>'bank_code','classInput'=>'w-full','classLabel'=>'w-full hidden','label'=>'Chọn ngân hàng (*)','listItem'=>$data['banks'],'keyValue'=>'id','keyName'=>'name','selectedItem'=>[],'message'=>($errors->has('bank_code'))?$errors->first('bank_code'):''])

        
        @include('laravellayout::components.formTextarea',['name'=>'notes','classInput'=>'w-full','classLabel'=>'w-full hidden','value'=>old('notes'),'label'=>'Ghi chú','message'=>($errors->has('notes'))?$errors->first('notes'):''])



        <div class='overflow-hidden w-full'><input id='btnCheckout' type="submit" value="Xác Nhận Thanh Toán" class="btn btn-danger w-full  md:w-44 md:m-auto p-2 text-white rounded-lg "style='display:list-item'></div> 

        

  
    </form>
</div> 
<script>
$(document).ready(function () {

    $('#btnCheckout').click(function () {
        $('#btnCheckout').attr('disabled', true);
        $('#formCheckout').submit();
        return true;
    });

});
</script>
 
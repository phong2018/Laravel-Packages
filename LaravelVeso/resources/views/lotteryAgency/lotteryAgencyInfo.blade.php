<div class='lotteryAgencyInfo'>
<h2 class='font-bold pt-3 pb-4'>Thông tin đại lý Vé số - Hiển thị trên vé In KQXS</h2>

<x-laravelcomponent-forminput classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'  name="agencyName" value="{{old('agencyName',$user['agency_info']['agencyName'])}}" label="Tên đại lý" type="text" message="{{($errors->has('agencyName'))?$errors->first('agencyName'):''}}" />

<x-laravelcomponent-forminput classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'  name="agencyPhone" value="{{old('agencyPhone',$user['agency_info']['agencyPhone'])}}" label="Số điện thoại" type="text" message="{{($errors->has('agencyPhone'))?$errors->first('agencyPhone'):''}}" />

<x-laravelcomponent-forminput classLabel='w-4/12 md:w-3/12' classInput='w-8/12 md:w-9/12 float-right'  name="agencyAddress" value="{{old('agencyAddress',$user['agency_info']['agencyAddress'])}}" label="Địa chỉ" type="text" message="{{($errors->has('agencyAddress'))?$errors->first('agencyAddress'):''}}" />

</div>
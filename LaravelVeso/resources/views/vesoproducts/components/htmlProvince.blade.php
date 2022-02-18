@include('laravellayout::components.formSelectProvince',['name'=>'province','label'=>'Chọn tỉnh','listItem'=>$provinces,'keyValue'=>'slug','keyName'=>'name','selectedItem'=>[],'message'=>($errors->has('province'))?$errors->first('province'):'','classLabel'=>'w-5/12 md:w-4/12','classInput'=>'w-7/12 md:w-8/12 float-right'])



 
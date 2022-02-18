
<?php 
use Phonglg\LaravelVeso\Helpers\TraditionalTicket;
?>
@extends($template)

@section('content')
    {{-- {{dd($vesoproducts)}} --}}
    @if(Auth::user()->role_id>config('laraveluserrole.defaultRoleId'))
    <div class="w-full">
        <h1 class="pagetitle">Danh Sách Vé Số</h1>
        <div>
            <a href={{route('vesoproducts.create')}} class="btn btn-primary float-rights text-white mb-2">
            Tạo Vé 
            </a>  
            <a href={{route('vesoproducts.sale')}} class="btn btn-success float-rights text-white mb-2">
            Bán Vé 
            </a>

            <form title='Ngừng bán' class="inline" id="formUnSoldAllTicket" method="POST"  action="{{route('vesoproducts.unSoldAllTicket')}}">
                @csrf 
                <button  type="submit" onClick="confirmFormSubmit('formUnSoldAllTicket')" class="btn  btn-danger float-rights text-white mb-2">
                Ngừng bán 
                </button>
            </form>  
            
        </div>
    </div>
    @endif

    @if(session('message')) 
        <div class="alert alert-success"><p class='m-0'>{{session('message')}}</p></div>    
    @endif

    @if(session('error')) 
        <div class="alert alert-danger"><p class='m-0'>{{session('error')}}</p></div>    
    @endif

    <!-- form -->
    <form action="{{$data['actionInvoiceStatistics']}}" method="GET"  enctype="multipart/form-data" class='overflow-hidden p-2 mb-2 bg-gray-100'>
        @include('laravelveso::component.formFromToDate',['actionFrom'=>$data['actionInvoiceStatistics'],'fromDate'=>date("d-m-Y", strtotime($data['invoiceStatistics']['fromDate'])),'toDate'=>date("d-m-Y", strtotime($data['invoiceStatistics']['toDate']))])  

        @if(Auth::user()->role_id<config('laraveluserrole.defaultRoleId'))
            @include('laravellayout::componentsFilter.formSelect',['name'=>'agency','label'=>'Đại lý','listItem'=>$data['agencies'],'keyValue'=>'id','keyName'=>'agency_name','selectedItem'=>$data['agency'],'message'=>($errors->has('agency'))?$errors->first('agency'):'','classLabel'=>'w-5/12 md:w-4/12','classInput'=>'w-7/12 md:w-8/12 float-right'])
        @endif

        <div  class='p-1 inline'>
        <button type="submit" class="bg-blue-500  p-1  text-white rounded-lg">Thống Kê</button>
        </div> 

    </form>

    @include('laravelveso::vesoproducts.components.reportVesoProduct')

    @if($vesoproducts->count()>0)
    <div class="overflow-x-scroll  ">
        <table class="table table-striped">
            <tr class="listTable">
                <th>#</th>
                <th class="text-center">Chức năng</th>
      
                <th>Vé Số</th> 
                <th>Ngày</th> 
                <th>Tỉnh</th> 
                <th>Loại</th> 
                <th>Giá</th> 
                <th>SL</th>
                <th>Bán Oln</th>
                <th>Bán TT</th>
                <th>Ế</th>
                <th>Đại lý</th>
                <th>TT</th>  
                
            </tr>  
            @foreach($vesoproducts as $no=>$vesoproduct)
            <tr>
                <!-- Form quick Edit  -->
                <td>{{ $no+1}}</td>
                <!-- End Form quick Edit  -->
                <td class='text-center'>
                    <table class='text-center w-full' ><td>
                    @can('update',$vesoproduct)
                        <a title='Sửa' href="{{route('vesoproducts.edit',['vesoproduct'=>$vesoproduct])}}" class="p-1">
                        <i class="far fa-edit"></i>
                        </a>
                    @endcan 
                    </td><td>
                    <form title='Sao chép' class="inline" method="POST"  action="{{route('vesoproducts.copy',['vesoproduct'=>$vesoproduct])}}">
                        @csrf 
                        <button type="submit" class="p-1"> <i class="far fa-copy" ></i></button>
                    </form>  
                    </td><td>
                    @can('delete',$vesoproduct)
                    <form title='Xóa' class="inline" id="formDelete{{$vesoproduct['id']}}" method="POST"  action="{{route('vesoproducts.destroy',['vesoproduct'=>$vesoproduct])}}">
                        @csrf
                        @method("DELETE")
                        <button type="submit" onClick="confirmFormSubmit('formDelete{{$vesoproduct['id']}}')" class="p-1">
                        <i class="far fa-trash-alt"  ></i>
                        </button>
                    </form> 
                    @endcan  
                    </td>
                    <td>
                    @can('delete',$vesoproduct)
                    @if($vesoproduct->quantity>0)
                        <form title='Ngừng bán' class="inline" id="formUnSoldTicket{{$vesoproduct['id']}}" method="POST"  action="{{route('vesoproducts.unSoldTicket',['vesoproduct'=>$vesoproduct])}}">
                            @csrf 
                            <button type="submit" onClick="confirmFormSubmit('formUnSoldTicket{{$vesoproduct['id']}}')" class="p-1">
                            <i class="fas fa-ban"></i>
                            </button>
                        </form> 
                    @else
                    <td>
                        <button class="p-1 pointer-events-none"><i class="fas fa-ban text-gray-300"></i></button> 
                    </td>
                    @endif
                    @endcan  
                    </td>
                
                    </table>
                </td>
              
                <td class='font-bold'>{{$vesoproduct->number}}</td>   
                <td title='{{date("d/m/Y", strtotime($vesoproduct->prize_date))}}'>{{date("d/m", strtotime($vesoproduct->prize_date))}}</td> 
                <td>{{$vesoproduct->showProvince()}}</td> 
                <td>{{config('laravelhtmldomparser.categoryType.traditionallottery.gameType.'.$vesoproduct->game_type.'.name') }}</td>
                <td>{{number_format($vesoproduct->price)}}</td> 
                <td>{{$vesoproduct->quantity}}</td> 
                <td>{{$vesoproduct->quantity_sold}}</td> 
                <td>{{$vesoproduct->quantity_sold_direct}}</td> 
                <td>{{$vesoproduct->quantity_unsold}}</td> 
                <td>{{$vesoproduct->user->agency_name}}</td> 
                <td>
                    @if($vesoproduct->status==1)    
                    <i title='Đang bán' class="far fa-eye cursor-pointer"></i>
                    @else
                    <i title='Ngừng bán'  class="far fa-eye-slash cursor-pointer"></i>
                    @endif 
                </td> 
            </tr>
            @endforeach
        </table>  
    </div>
    @endif
    @include('laravellayout::partial.popup.formConfirm') 
    <script>
        function stopSaling(){
            alert('tt');
        }
    </script>
@endsection

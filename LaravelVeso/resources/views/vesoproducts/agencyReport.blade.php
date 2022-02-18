
<?php
use Phonglg\LaravelVeso\Helpers\ImageHelper;
use  App\Models\User;
?>
@extends(config('laravelveso.layoutAdmin'))

@section('content')
    {{-- {{dd($vesoproducts)}} --}}
    <div class="w-full">
        <h1 class="pagetitle">Thống kê doanh số Đại lý</h1>
    </div>

    @if(session('message')) 
        <div class="alert alert-success"><p class='m-0'>{{session('message')}}</p></div>    
    @endif

    @if(session('error')) 
        <div class="alert alert-danger"><p class='m-0'>{{session('error')}}</p></div>    
    @endif
    <!-- form -->
    <form action="{{$data['actionAgencyReport']}}" method="GET"  enctype="multipart/form-data" class='overflow-hidden p-2 mb-2 bg-gray-100'>
        @include('laravelveso::component.formFromToDate',['actionFrom'=>$data['actionAgencyReport'],'fromDate'=>date("d-m-Y", strtotime($data['invoiceStatistics']['fromDate'])),'toDate'=>date("d-m-Y", strtotime($data['invoiceStatistics']['toDate']))])  
        <div  class='p-1 inline'>
            <button type="submit" class="bg-blue-500  p-1  text-white rounded-lg">Thống Kê</button>
        </div>  
    </form>
    @if($vesoproducts->count()>0)
    <div class="overflow-x-scroll  ">
        <table class="table  text-center">
            <tr class="listTable">
                <th>#</th> 
                <th>Đại lý</th> 
                <th>Loại vé</th> 
                <th>SL đã bán <br>(1)</th> 
                <th>SL vé thưởng <br>(2)</th> 
                <th>SL đã thanh toán <br>(3)</th>  
                <th>Số tiền đã thanh toán <br>(3)</th>  
            </tr>  
            @foreach($vesoproducts as $no=>$vesoproduct)
            <?php $ticketNeedPaid=$vesoproduct->totalQuantitySold-$vesoproduct->totalQuantityReward-$vesoproduct->totalQuantityPaid;  ?>
            <tr> 
                <td>{{ $no+1}}</td> 
              
                <td class=''>{{User::find($vesoproduct->user_create_id)->name}}</td>   
                <td class=''>{{config('laravelhtmldomparser.categoryType.traditionallottery.gameType.'.$vesoproduct->game_type.'.name')}}</td>   
                <td class=''>{{$vesoproduct->totalQuantitySold-0}}</td>  
                <td class=''>{{$vesoproduct->totalQuantityReward-0}}</td>  
                <td class=''>{{$vesoproduct->totalQuantityPaid-0}}</td>  
                <td class=''>{{number_format(($vesoproduct->totalQuantityPaid-0)*config('laravelveso.priceTicket.'.$vesoproduct->game_type))}}Đ</td>  
            </tr>
            @endforeach
        </table>  
    </div>
    @endif
    @include('laravellayout::partial.popup.formConfirm') 
@endsection

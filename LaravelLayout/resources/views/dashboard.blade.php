@extends('laravellayout::layouts.admin')

@section('content')
    <h1 class="pagetitle">Trang Tổng Quát</h1>
    <div class='dashBoard'>
        <div class='w-full text-justify overflow-hidden '>

            <div class='itemDashboard w-1/3 pr-1'>
                <h2  title='Tổng điểm hiện tại của tất cả khách hàng và đại lý'>Tổng điểm trên hệ thống</h2> 

                <table style='background:#FFB848'>
                    <tr>
                    <td  class='w-1 pl-3'><i class="text-3xl md:text-4xl fas fa-ticket-alt"></i></td>
                    <td><span class='itemText text-3xl md:text-4xl'>{{number_format($data['totalPoint'])}}</span></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        <p class='viewtDetail pl-3'><a href="{{route('admin.point')}}">Xem chi tiết..</a></p>
                        </td>
                    </tr>
                </table>
 
            </div> 

            <div class='itemDashboard w-1/3 pl-1 pr-1'>
                <h2 title='Tổng số khách hàng' >Tổng Số Khách Hàng</h2>
             
                <table style='background:#27A9E3'>
                    <tr>
                    <td class='w-1 pl-3'><i class="text-3xl md:text-4xl fas fa-users"></i></td>
                    <td><span class='itemText text-3xl md:text-4xl '>{{$data['totalCustomer']}}</span></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        <p class='viewtDetail pl-3'><a href="{{route('customers.index')}}">Xem chi tiết..</a></p>
                        </td>
                    </tr>
                </table> 
            </div>


            <div class='itemDashboard w-1/3 pl-1'>
                <h2 title='Tổng số đại lý' >Tổng Số Đại Lý</h2> 
                <table style='background:#28B779'>
                    <tr>
                    <td  class='w-1 pl-3'><i class="text-3xl md:text-4xl fas fa-sitemap"></i> </td>
                    <td><span class='itemText text-3xl md:text-4xl '>{{$data['totalAgency']}}</span></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        <p class='viewtDetail pl-3'><a href="{{route('customers.index')}}">Xem chi tiết..</a></p>
                        </td>
                    </tr>
                </table>
 
            </div>
        </div>
        <!-- detail point -->
        <div class='border border-white pt-3 '>
            <h2>Chi tiết điểm</h2>
            <div class='overflow-x-auto w-full'>
            <table class='table text-center border'> 
                <tr class='font-bold'><td>Tổng điểm trên hệ thống <br>(1)=(2)+(3)+(4)+(5)+(6)-(7)-(8)-(9)</td><td>Điểm nạp<br>(2)</td><td>Điểm hoàn tiền<br>(3)</td><td>Điểm thắng giải<br>(4)</td><td>Điểm T.toán Đ.lý<br>(5)</td><td>Hoa hồng giới thiệu<br>(6)</td><td>Điểm Rút<br>(7)</td><td>Điểm mua vé<br>(8)</td><td>Điểm trả thưởng<br>(9)</td></tr>
                <tr>
                <td class='font-bold'>
                {{number_format(($data['totalPointDetail']['pointAdd'])-($data['totalPointDetail']['pointWithdraw'])-($data['totalPointDetail']['pointBuyTicket'])+ ($data['totalPointDetail']['pointCommissionForPresenter']) + ($data['totalPointDetail']['pointRefund'])+($data['totalPointDetail']['pointWinPrize'])+($data['totalPointDetail']['pointPaidSaleTicketForAgency'])-($data['totalPointDetail']['pointPaidPrize']) )}}
                </td>
                <td>{{number_format($data['totalPointDetail']['pointAdd'])}}</td><td>{{number_format($data['totalPointDetail']['pointRefund'])}}</td><td>{{number_format($data['totalPointDetail']['pointWinPrize'])}}</td><td>{{number_format($data['totalPointDetail']['pointPaidSaleTicketForAgency'])}}</td><td>{{number_format($data['totalPointDetail']['pointCommissionForPresenter'])}}</td><td>{{number_format($data['totalPointDetail']['pointWithdraw'])}}</td><td>{{number_format($data['totalPointDetail']['pointBuyTicket'])}}</td><td>{{number_format($data['totalPointDetail']['pointPaidPrize'])}}</td></tr>
                
            </table>
            </div> 
        </div>
        <!-- ----------- -->
        <div class='w-full overflow-hidden'>
            <div class='itemRecent float-left pr-1'>
                <h2>Tổng Doanh số hôm nay</h2>
                <table  style='background:#DA542E;color:white;'>
                    <tr>
                    <td  class='w-1 pl-3'><i class="text-4xl md:text-6xl fas fa-money-bill-wave"></i></td>
                    <td><span class='itemText text-4xl md:text-6xl'>{{number_format($data['totalSalesBuyTicketToday'])}}Đ</span></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        <p class='viewtDetail pl-3'><a href="{{route('admin.order')}}">Xem chi tiết..</a></p>
                        </td>
                    </tr>
                </table> 
                
            </div>
            
            <div class='itemRecent float-right pl-1'>
                <h2>Tổng Tiền Nạp Hôm Nay</h2>
                <table style='background:#2255A4;color:white;'>
                    <tr>
                    <td  class='w-1 pl-3'><i class="text-4xl md:text-6xl fas fa-money-check-alt"></i></td>
                    <td><span class='itemText text-4xl md:text-6xl'>{{number_format($data['totalSalesBuyPointToday'])}}Đ</span></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        <p class='viewtDetail pl-3'><a href="{{route('admin.point')}}">Xem chi tiết..</a></p>
                        </td>
                    </tr>
                </table> 
                
            </div> 
        </div>
        
        <br>
        <h2>Hóa Đơn Hôm Nay {{count($data['recentOrdersBuyTicket'])}} - Hoàn lại {{$data['countOrderRefund']}}</h2>
        @include('laravelveso::component.listOrder',['orders'=>$data['recentOrdersBuyTicket']])

    </div>

@endsection

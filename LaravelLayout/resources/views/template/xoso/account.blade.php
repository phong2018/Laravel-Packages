

    <ul class="flex items-center float-right"> 
        
        @auth
        <li>
            <form action="{{ Route::has('logout')?route('logout'):false }}" method="post" class="inline">
                @csrf
                <button  class='btn-top bg-red-400' type="submit">Đăng xuất</button>
            </form>

        </li>
        <li> 
            <div class="dropdown account bg-blue-400">
                <button class=" "><i class="fas fa-user-circle"></i> {{substr(auth()->user()->name,0,8)}} <i class="fas fa-chevron-down text-xs"></i> </button>
                <div class="dropdown-content">
                    <a href="{{route('customer.order')}}">Hóa Đơn</a>
                    <a href="{{route('point.list')}}">Nạp tiền</a>
                    <a href="{{route('point.withdrawAccumulatePoint')}}">Điểm tích lũy</a>
                    <a href="{{ Route::has('account.edit')? route('account.edit'):false }}" class='p-3'>Thông tin</a>
                    @if(auth()->user()->role_id==config('laraveluserrole.defaultAgencyRoleId'))
                        <a href="{{route('vesoproducts.index')}}">Bán Vé</a>
                        <a href="{{route('order.reportWinPrizes')}}">Trả thưởng</a>
                        <a href="{{route('agency.listOrdersSale')}}">Hóa đơn bán</a>
                    @endif
                    
                    <a href="{{route('winPrizeNotification.list')}}">Thông báo</span></a>

                    <a href="{{route('account.customerList')}}">Tiếp Thị</a>

                    <a href="{{route('account.LogsList')}}">Lịch Sử</a>

                    

                    
                    
                </div>
            </div> 
        </li>
        @endauth

        @guest
        <li>
            <a href="{{ route('login') }}" class='btn-top bg-blue-400'>Đăng nhập</a>
        </li>
        <li>
            <a href={{ route('register') }} class='btn-top bg-red-400'>Đăng ký</a>
        </li>
        @endguest
</ul>

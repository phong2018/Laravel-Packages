 
    <ul class="flex items-center float-right">

        <li>
             @auth
                @if(auth()->user()->unreadNotifications->count()>0)
                    <a href="{{route('winPrizeNotification.list')}}"><i class="fas fa-bell "></i> <span class='totalItem'>[<span id='totalItem'>{{auth()->user()->unreadNotifications->count()}}</span>]</span></a>
                @endif
            @endauth
        </li>

        <li>
            <a href="{{ route('account.LogsList') }}" class='p-3 px-2'>
            <i class="fas fa-clipboard-list"></i>
            </a>
        </li>

        <li>
            <a href="{{ route('buyLottery.buyTraditionalLottery') }}" class='p-3 px-2'>Shop</a>
        </li>  

        @auth
        <li>
            <a href="{{ Route::has('account.edit')? route('account.edit'):false }}" class='p-3 px-2'>{{auth()->user()->name}}</a>
        </li>
        <li>
            <form action="{{ Route::has('logout')?route('logout'):false }}" method="post" class="inline p-3">
                @csrf
                <button type="submit">Logout</button>
            </form>

        </li>
        @endauth

        @guest
        <li>
            <a href="{{ route('login') }}" class='p-3 px-2'>Login</a>
        </li>
        <li>
            <a href={{ route('register') }} class='p-3 px-2'>Register</a>
        </li>
        @endguest
    </ul>
 
 
    <ul class="flex items-center float-right">

    
        <li>
            <a href="{{ route('shop.index') }}" class='p-3'>Shop</a>
        </li>

        @auth
        <li>
            <a href="{{ Route::has('account.edit')? route('account.edit'):false }}" class='p-3'>{{auth()->user()->name}}</a>
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
            <a href="{{ route('login') }}" class='p-3'>Login</a>
        </li>
        <li>
            <a href={{ route('register') }} class='p-3'>Register</a>
        </li>
        @endguest
    </ul>
 
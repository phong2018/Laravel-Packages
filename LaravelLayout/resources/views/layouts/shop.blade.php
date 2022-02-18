<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('packages/css/tailwind/tailwind.css') }}" rel="stylesheet">
    <link href="{{ asset('packages/css/bootstrap/bootstrap.css') }}" rel="stylesheet"> 
    <script src="{{ asset('packages/js/jquery/jquery.js') }}"></script>
    <title>Laravel</title>
</head>

<body class="bg-gray-300">
    <div class="flex justify-center">
        <div class="w-full bg-white rounded-lg">
            <div class="w-full h-10 p-2 border">
                @include('laravellayout::partial.common.account')  
                <a href="{{route('cart.index')}}">Cart [{{Gloudemans\Shoppingcart\Facades\Cart::content()->count()}}]</a>
            </div>
            <div class="p-3">
                @yield('content')
            </div> 
        </div>
    </div>
</body>

</html>
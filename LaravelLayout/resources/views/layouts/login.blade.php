<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('packages/css/tailwind/tailwind.css') }}" rel="stylesheet">
    <link href="{{ asset('packages/css/bootstrap/bootstrap.css') }}" rel="stylesheet"> 
    <title>Laravel</title>
</head>

<body class="bg-gray-300">
    <nav class="p-6 bg-white flex justify-between mb-3">
        <ul class="flex items-center">
            Home
        </ul>
        @include('laravellayout::partial.common.account') 
    </nav>

    <div class="flex justify-center">
        <div class="w-11/12 bg-white p-3 rounded-lg">
            @yield('content')
        </div>
    </div>
</body>

</html>
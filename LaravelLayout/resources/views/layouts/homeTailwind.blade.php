<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('packages/css/tailwind/tailwind.css') }}" rel="stylesheet"> 
    <script src="{{ asset('packages/js/jquery/jquery.js') }}"></script>
    <title>Laravel</title>
</head>
<body> 
    @yield('content')
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>ThanTai39.vn</title>
	
	<!--Responsiveness-->
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<!--FontAwesome-->
    <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet"> 
    <link href="{{ asset('laravellayout/home00/home00.css') }}" rel="stylesheet" />
    <link href="{{ asset('laravellayout/home00/ace-responsive-menu.css') }}" rel="stylesheet" />

    <link href="{{ asset('storage/photos/1/Default/icon.png') }}" rel="icon" />
    <script src="{{ asset('packages/js/jquery/jquery.js') }}"></script>
    <link href="{{ asset('packages/css/bootstrap/bootstrap.css') }}" rel="stylesheet"> 
    <link href="{{ asset('packages/css/tailwind/tailwind.css') }}" rel="stylesheet">
    <link href="{{ asset('packages/css/sass/buylottery.css') }}" rel="stylesheet"> 
    <link href="{{ asset('packages/css/sass/stylesheet.css') }}" rel="stylesheet"> 

</head>
<body>    

    @include('laravellayout::template.xoso.header')

    <div class="container overflow-hidden pt-1 "> 
        <div class="bg-white md:bg-white md:flex">
            <div id="colLeft" class="w-full md:w-2/12  hidden md:inline">
                @include('laravellayout::template.xoso.colLeft')
            </div>
            <div id='content' class="w-full  md:w-7/12" > 
                @yield('content')
            </div> 
            <div  id="colRight" class="w-full md:w-3/12 ">
                @include('laravellayout::template.xoso.colRight')
            </div>
        </div> 
    </div> 
    @include('laravellayout::template.xoso.footer')


</body>
</html>

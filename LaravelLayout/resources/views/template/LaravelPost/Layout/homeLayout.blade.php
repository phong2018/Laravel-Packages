<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Hoccode.net</title>
	
	<!--Responsiveness-->
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<!--FontAwesome-->
    <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet"> 
    <link href="{{ asset('laravellayout/home00/home00.css') }}" rel="stylesheet" />
    <link href="{{ asset('laravellayout/home00/ace-responsive-menu.css') }}" rel="stylesheet" />
    
    <link href="https://hoccode.net/storage/photos/1/Default/logo.png" rel="icon" />
    <!-- common -->
    <script src="{{ asset('packages/js/jquery/jquery.js') }}"></script>
    <link href="{{ asset('packages/css/bootstrap/bootstrap.css') }}" rel="stylesheet"> 
    <link href="{{ asset('packages/css/tailwind/tailwind.css') }}" rel="stylesheet"> 
    <!-- specific -->
    <link href="{{ asset('packages/css/LaravelPost/stylesHome.css') }}" rel="stylesheet"> 

</head>
<body> 
    @include('laravellayout::template.LaravelPost.Component.header')

    <div class="container overflow-hidden pt-1 "> 
        <div class="bg-white md:bg-white md:flex"> 
            <div id='content' class="w-full  md:w-9/12" > 
                @yield('content')
            </div> 
            <div  id="colRight" class="w-full md:w-3/12 ">
                @include('laravellayout::template.LaravelPost.Component.colRight')
            </div>
        </div> 
    </div> 
    @include('laravellayout::template.LaravelPost.Component.footer')


</body>
</html>

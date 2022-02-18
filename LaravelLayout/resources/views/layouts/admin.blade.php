<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('packages/css/bootstrap/bootstrap.css') }}" rel="stylesheet"> 
    <link href="{{ asset('packages/css/tailwind/tailwind.css') }}" rel="stylesheet">
    <script src="{{ asset('packages/js/jquery/jquery.js') }}"></script>
    <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet"> 
    <link href="{{ asset('storage/photos/1/Default/icon.png') }}" rel="icon" />
    <link href="{{ asset('laravellayout/admin03/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('packages/css/sass/adminStyle.css') }}" rel="stylesheet"> 
    <title>Laravel</title>
</head>

<body class="bg-gray-300">
<div class="page-wrapper chiller-theme toggled">
  <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
    <i class="fas fa-bars"></i>
  </a>
  
  @include('laravellayout::partial.common.menuVeso') 

  <main class="page-content">
    <div class="container-fluid bg-gray-200 h-12 ">
    @include('laravellayout::partial.common.accountVeso') 
    </div>
    <div class="container-fluid">
     @yield('content')
    </div>
  </main> 
</div> 
<script src="{{ asset('laravellayout/admin03/common.js') }}"></script>
</body>
</html>
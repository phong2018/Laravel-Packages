<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('packages/css/tailwind/tailwind.css') }}" rel="stylesheet">
    <link href="{{ asset('packages/css/bootstrap/bootstrap.css') }}" rel="stylesheet"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Laravel</title>
</head>

    <nav class="navbar navbar-inverse navbar-global navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
        
          </button>
          <a class="navbar-brand" href="#">Santhosh Vertical Nav Project</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          @include('laravellayout::partial.common.account') 
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<nav class="navbar-primary">
  <a href="#" class="btn-expand-collapse"> << </a>
  <ul class="navbar-primary-menu">
    <li>
      <a href="#">Ic1 <span class="nav-label">Dashboard</span></a> 
      
      <a href="{{ route('dashboard') }}" class='p-3 text-white'>Ic1 <span class="nav-label">Dashboard</a>

      @can('viewAny',Phonglg\LaravelUserRole\Models\User::class)
          <a href="{{ route('users.index') }}" class='p-3 text-white'>Ic1 <span class="nav-label">Users</span></a>
      @endcan

      @can('viewAny',Phonglg\LaravelUserRole\Models\Role::class)
          <a href="{{ route('roles.index') }}" class='p-3 text-white'>Ic1 <span class="nav-label">Roles</span></a>
      @endcan

      @can('viewAny',Phonglg\LaravelEcommerce\Models\Product::class)
          <a href="{{ route('products.index') }}" class='p-3 text-white'>Ic1 <span class="nav-label">Products</span></a>
      @endcan
      @can('viewAny',Phonglg\LaravelEcommerce\Models\Category::class)
          <a href="{{ route('categories.index') }}" class='p-3 text-white'>Ic1 <span class="nav-label">Categories</span></a>
      @endcan
      @can('viewAny',Phonglg\LaravelSetting\Models\Setting::class)
          <a href="{{ route('settings.index') }}" class='p-3 text-white'>Ic1 <span class="nav-label">Settings</span></a>
      @endcan
    </li> 
    
  </ul>
</nav>
<div class="main-content">
@yield('content')
</div>

<script src="{{ asset('laravellayout/admin01/common.js') }}"></script>
<link href="{{ asset('laravellayout/admin01/style.css') }}" rel="stylesheet" />

</body>
</html>

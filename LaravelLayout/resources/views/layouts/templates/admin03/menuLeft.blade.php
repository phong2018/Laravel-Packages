<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <a href="#">Laravel Package</a>
        <div id="close-sidebar">
          <i class="fas fa-times"></i>
        </div>
      </div>
      <div class="sidebar-header">
        <div class="user-pic">
          <img class="img-responsive img-rounded" src="{{ asset('laravellayout/images/user.jpg') }}"
            alt="User picture">
        </div>
        <div class="user-info">
          <span class="user-name">Jhon
            <strong>Smith</strong>
          </span>
          <span class="user-role">Administrator</span>
          <span class="user-status">
            <i class="fa fa-circle"></i>
            <span>Online</span>
          </span>
        </div>
      </div>
      <!-- sidebar-header  -->
      <div class="sidebar-search hidden">
        <div>
          <div class="input-group">
            <input type="text" class="form-control search-menu" placeholder="Search...">
            <div class="input-group-append">
              <span class="input-group-text">
                <i class="fa fa-search" aria-hidden="true"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
      <!-- sidebar-search  -->
      <!-- https://fontawesome.com/v4.7/icons/ -->
      <div class="sidebar-menu">
        <ul>

          <li>
          <a href="{{ route('dashboard') }}">
              <i class="fa fa-tachometer-alt"></i>
              <span>Dashboard</span>
            </a>
          </li>
           
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-shopping-cart"></i>
              <span>Shop</span>
              <!-- <span class="badge badge-pill badge-danger">3</span> -->
            </a>
            <div class="sidebar-submenu">
              <ul>
                @can('viewAny',Phonglg\LaravelEcommerce\Models\Product::class)
                <li>
                    <a href="{{ route('products.index') }}" class='p-3 text-white'>Products</a>
                </li>
                @endcan

                @can('viewAny',Phonglg\LaravelEcommerce\Models\Category::class)
                <li>
                    <a href="{{ route('categories.index') }}" class='p-3 text-white'>Categories</a>
                </li>
                @endcan

                @can('viewAny',Phonglg\LaravelEcommerce\Models\Category::class)
                <li>
                    <a href="{{ route('categories.index') }}" class='p-3 text-white'>Orders</a>
                </li>
                @endcan
              </ul>
            </div>
          </li>

          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-book"></i>
              <span>News</span>
              <!-- <span class="badge badge-pill badge-danger">3</span> -->
            </a>
            <div class="sidebar-submenu">
              <ul>
                @can('viewAny',Phonglg\LaravelEcommerce\Models\Product::class)
                <li>
                    <a href="{{ route('products.index') }}" class='p-3 text-white'>Posts</a>
                </li>
                @endcan

                @can('viewAny',Phonglg\LaravelEcommerce\Models\Category::class)
                <li>
                    <a href="{{ route('categories.index') }}" class='p-3 text-white'>Threads</a>
                </li>
                @endcan

                @can('viewAny',Phonglg\LaravelEcommerce\Models\Category::class)
                <li>
                    <a href="{{ route('categories.index') }}" class='p-3 text-white'>Comments</a>
                </li>
                @endcan
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-cog" aria-hidden="true"></i>
              <span>Setting</span>
              <!-- <span class="badge badge-pill badge-danger">3</span> -->
            </a>
            <div class="sidebar-submenu">
              <ul>
                @can('viewAny',Phonglg\LaravelUserRole\Models\User::class)
                <li>
                    <a href="{{ route('users.index') }}" class='p-3 text-white'>Users</a>
                </li>
                @endcan
                @can('viewAny',Phonglg\LaravelUserRole\Models\Role::class)
                <li>
                    <a href="{{ route('roles.index') }}" class='p-3 text-white'>Roles</a>
                </li>
                @endcan
                @can('viewAny',Phonglg\LaravelSetting\Models\Setting::class)
                <li>
                    <a href="{{ route('settings.index') }}" class='p-3 text-white'>Setting</a>
                </li>
                @endcan
                @can('viewAny',Phonglg\LaravelEcommerce\Models\Category::class)
                <li>
                    <a href="{{ route('categories.index') }}" class='p-3 text-white'>Backup</a>
                </li>
                @endcan              
              </ul>
            </div>
          </li> 
        </ul>
      </div>
      <!-- sidebar-menu  -->
    </div> 
  </nav>
  <!-- sidebar-wrapper  -->
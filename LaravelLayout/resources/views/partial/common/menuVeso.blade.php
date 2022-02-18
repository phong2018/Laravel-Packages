<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <a href="#">ThanTai39.Vn</a>
        <div id="close-sidebar">
          <i class="fas fa-times"></i>
        </div>
      </div>
      <div class="sidebar-header">
        <div class="user-pic"> 
        <i class="fas fa-user-circle text-white text-5xl"></i>
        </div>
        <div class="user-info">
          <span class="user-name">
          {{Auth::user()->name}}
          </span>
          <span class="user-role">
          {{Auth::user()->role->name}}
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
              <span>Tổng Quát</span>
            </a>
          </li>
           
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-shopping-cart"></i>
              <span>Bán vé</span>
              <!-- <span class="badge badge-pill badge-danger">3</span> -->
            </a>
            <div class="sidebar-submenu">
              <ul>
                @can('viewAny',Phonglg\LaravelVeso\Models\Vesoproduct::class)
                <li>
                    <a href="{{ route('vesoproducts.index') }}" class='p-3 text-white'>Vé số</a>
                </li>
                <li>
                    <a href="{{ route('vesoproducts.agencyReport') }}" class='p-3 text-white'>Doanh số Đại lý</a>
                </li>
                @endcan

                 
              </ul>
            </div>
          </li>

          <li class="sidebar-dropdown">
            <a href="#">
              <i class="far fa-newspaper"></i>
              <span>Bài Viết</span>
              <!-- <span class="badge badge-pill badge-danger">3</span> -->
            </a>
            <div class="sidebar-submenu">
              <ul>
                @can('viewAny',Phonglg\LaravelPost\Models\Post::class)
                <li>
                    <a href="{{ route('post.index') }}" class='p-3 text-white'>Bài Viết</a>
                </li> 
                @endcan
                @can('viewAny',Phonglg\LaravelPost\Models\Thread::class)
                <li>
                    <a href="{{ route('thread.index') }}" class='p-3 text-white'>Thread</a>
                </li> 
                @endcan
                 
              </ul>
            </div>
          </li>

          <li class="sidebar-dropdown">
            <a href="#">
            <i class="fas fa-chart-bar" ></i>
              <span>Báo Cáo</span>
              <!-- <span class="badge badge-pill badge-danger">3</span> -->
            </a>
            <div class="sidebar-submenu">
              <ul>
              @can('viewAny',Phonglg\LaravelVeso\Models\Order::class)
                <li>
                    <a href="{{ route('admin.order') }}" class='p-3 text-white'>Hóa Đơn</a>
                </li>

                <li>
                    <a href="{{ route('admin.listOrdersSaleVietlott') }}" class='p-3 text-white'>Hóa Đơn Vietlott</a>
                </li>

              @endcan

              @can('viewAny',Phonglg\LaravelVeso\Models\Point::class)
                
                <li>
                    <a href="{{ route('admin.point') }}" class='p-3 text-white'>Nạp & Rút Tiền</a>
                </li>
              @endcan

              @can('viewAny',Phonglg\LaravelVeso\Models\Order::class)
                <li>
                    <a href="{{ route('order.reportWinPrizes') }}" class='p-3 text-white'>Trả Thưởng</a>
                </li>
                <li>
                    <a href="{{ route('admin.indexOrderWithdrawPointAccumulate') }}" class='p-3 text-white'>Đổi điểm</a>
                </li>
              @endcan
                 
              </ul>
            </div>
          </li>

          <li class="sidebar-dropdown">
            <a href="#">
            <i class="fas fa-user-alt"></i>
              <span>Tài Khoản</span>
              <!-- <span class="badge badge-pill badge-danger">3</span> -->
            </a>
            <div class="sidebar-submenu">
              <ul>
                
                @can('viewAny',Phonglg\LaravelUserRole\Models\Customer::class)
                <li>
                    <a href="{{ route('customers.index') }}" class='p-3 text-white'>Khách Hàng</a>
                </li>
                <li>
                    <a href="{{ route('agency.list') }}" class='p-3 text-white'>Đại Lý</a>
                </li>
                @endcan
                
                @can('viewAny',Phonglg\LaravelUserRole\Models\User::class)
                <li>
                    <a href="{{ route('users.index') }}" class='p-3 text-white'>Tài Khoản</a>
                </li>
                @endcan
              </ul>
            </div>

          
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-cog" aria-hidden="true"></i>
              <span>Hệ Thống</span>
              <!-- <span class="badge badge-pill badge-danger">3</span> -->
            </a>
            <div class="sidebar-submenu">
              <ul>
                
                @can('viewAny',Phonglg\LaravelUserRole\Models\Role::class)
                <li>
                    <a href="{{ route('roles.index') }}" class='p-3 text-white'>Vai Trò</a>
                </li>
                @endcan
                @can('viewAny',Phonglg\LaravelSetting\Models\Setting::class)
                <li>
                    <a href="{{ route('settings.index') }}" class='p-3 text-white'>Cấu Hình</a>
                </li>
                @endcan

                @can('backupDB')
                <li>
                    <a href="{{ route('backup.index') }}" class='p-3 text-white'>Sao Lưu</a>
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
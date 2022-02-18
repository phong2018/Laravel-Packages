<?php
use Phonglg\LaravelSetting\Helpers\SettingHelper;
?>
<header>
     <!-- Top -->
    <div id='top'>
        <div class="container flex justify-between  mb-3">  
            <a class='wellcome  hidden md:inline' href="/">
            Đại lý vé số Thantai39.vn - Trực Tiếp & In Kết Quả Xổ Số NHANH NHẤT
            </a>
            <div>
                
            @auth
                @if(auth()->user()->unreadNotifications->count()>0)
                    <a href="{{route('winPrizeNotification.list')}}"><i class="fas fa-bell"></i> <span class='totalItem'>[<span id='totalNotification'>{{auth()->user()->unreadNotifications->count()}}</span>]</span></a>
                @endif
            @endauth

            <a href="{{route('cart.index')}}"><i class="fas fa-shopping-cart"></i> <span class='totalItem'>[<span id='totalItem'>{{Gloudemans\Shoppingcart\Facades\Cart::content()->count()}}</span>]</span></a>
            @include('laravellayout::template.xoso.account') 
            </div> 
        </div>
    </div> 
    <!-- bg-Top -->
    <div id='bg-top'>
        <div class="container">
            <a href="/"><img class='float-left' src="{{asset('/storage/photos/1/Default/logo.png')}}" alt="thantai39.vn"></a>
            <img class='float-right hidden md:inline' src="{{asset('/storage/photos/1/Default/dst.png')}}" alt="">
            
            <!-- <p class='text-blue-500 hidden md:text-red-500 md:inline' >test </p> -->
        </div>
    </div>

    <!-- Ace Responsive Menu -->
    <div class="container">       
        <nav id='menuHome'>
            <!-- Menu Toggle btn-->
            <div class="menu-toggle">
                
                <button type="button" id="menu-btn">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- Responsive Menu Structure-->
            <!--Note: declare the Menu style in the data-menu-style="horizontal" (options: horizontal, vertical, accordion) -->
            <ul id="respMenu" class="ace-responsive-menu" data-menu-style="horizontal">
                <li>
                    <a href="/">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        <span class="title">Trang Chủ</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <i class="fa fa-cube" aria-hidden="true"></i>
                        <span class="title">KQXS Truyền Thống</span>
                <span class="arrow"></span> 

                    </a>
                    <!-- Level Two-->
                    <ul>
                        <li>
                            <a href="{{route('prizes.showXosoMienNam')}}">Miền Nam</a>
                        </li>
                        <li>
                            <a href="{{route('prizes.showXosoMienTrung')}}">Miền Trung</a>
                        </li>
                        <li>
                            <a href="{{route('prizes.showXosoMienBac')}}">Miền Bắc</a>
                        </li> 
                    </ul>
                </li>

                <li>
                    <a href="javascript:;">
                        <i class="fa fa-fw fa-bolt"></i>
                        <span class="title">KQXS Vietlott</span>
                    <span class="arrow"></span> 

                    </a>
                    <!-- Level Two-->
                    <ul>
                        <li>
                            <a href="{{route('prizes.showXosoMega645')}}">Mega 6/45</a>
                        </li>
                        <li>
                            <a href="{{route('prizes.showXosoPower655')}}">Power 6/55</a>
                        </li>
                        <li>
                            <a href="{{route('prizes.showXosoMax3D')}}">Max 3D</a>
                        </li>
                        <li>
                            <a href="{{route('prizes.showXosoMax3DPro')}}">Max 3D Pro</a>
                        </li>
                        <li>
                            <a href="{{route('prizes.showXosoKeno')}}">Keno</a>
                        </li>
                    </ul>
                </li>
                
                <li>
                    <a href="javascript:;">
                    <i class="fa fa-credit-card" aria-hidden="true"></i>
                        <span class="title">Mua Vé Số</span>
                    <span class="arrow"></span> 

                    </a>
                    <!-- Level Two-->
                    <ul>
                        <li> 
                            <a href="{{route('buyLottery.buyTraditionalLottery')}}">Vé Số Truyền Thống</a>
                        </li>
                        <li>
                            <a href="{{route('buyLottery.buyMega645')}}">Mega 6/45</a>
                        </li>
                        <li>
                            <a href="{{route('buyLottery.buyPower655')}}">Power 6/55</a>
                        </li>
                        <li>
                            <a href="{{route('buyLottery.buyMax3D')}}">Max 3D</a> 
                        </li>
                        <li>
                            <a href="{{route('buyLottery.buyMax3DPlus')}}">Max 3D+</a> 
                        </li>
                        <li>
                        <a href="{{route('buyLottery.buyMax3DPro')}}">Max 3D Pro</a> 
                        </li>
                        <li>
                        <a href="{{route('buyLottery.buyKeno')}}">Keno</a> 
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:;">
                    <i class="fa fa-fw fa-print"></i>
                        <span class="title">In Vé Dò</span>
                    <span class="arrow"></span> 

                    </a>
                    <!-- Level Two-->
                    <ul>
                        <li>
                            <a target='_blank' href="{{route('printing.miennam')}}">Miền Nam</a>
                        </li>
                        <li>
                            <a target='_blank' href="{{route('printing.mientrung')}}">Miền Trung</a>
                        </li>
                        <li>
                            <a target='_blank' href="{{route('printing.mienbac')}}">Miền Bắc</a>
                        </li>
                        <li>
                            <a target='_blank' href="{{route('printing.mega645')}}">Mega 6/45</a>
                        </li>
                        <li>
                            <a target='_blank' href="{{route('printing.power655')}}">Power 6/55</a>
                        </li>
                        <li>
                            <a target='_blank' href="{{route('printing.max3d')}}">Max 3D</a>
                        </li>
                        <li>
                            <a  target='_blank'  href="{{route('printing.max3dpro')}}">Max 3D Pro</a>
                        </li>
                    </ul>
                </li> 
                <li class="last ">
                    <a href="{{SettingHelper::getKey('Url_Page_Gioi_thieu')}}">
                        <i class="fas fa-receipt"></i>
                        <span class="title">
                            Giới Thiệu
                        </span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End of Responsive Menu -->
    </div>
    <!--Scripts-->
    <script src="{{ asset('laravellayout/home00/ace-responsive-menu.js') }}"></script>
	
	<!--Plugin Initialization-->
     <script type="text/javascript">
         $(document).ready(function () {
             $("#respMenu").aceResponsiveMenu({
                 resizeWidth: '768', // Set the same in Media query       
                 animationSpeed: 'fast', //slow, medium, fast
                 accoridonExpAll: false //Expands all the accordion menu on click
             });
         });
	</script>
</header>
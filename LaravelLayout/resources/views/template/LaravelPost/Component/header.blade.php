<?php
    use Phonglg\LaravelSetting\Helpers\SettingHelper;
    use Phonglg\LaravelPost\Models\Thread;
    use Phonglg\LaravelPost\Models\Post;
    $data['threads']=Thread::orderBy('sort_order', 'asc')->where('parent_id',null)->get();
    foreach($data['threads'] as $thread){
        $childs=Thread::where('parent_id',$thread->id)->get();
        $data['childs'][$thread->id]=$childs;
    } 

    $data['aboutUs']=Post::find(2);
?>
<header>
     <!-- Top -->
    <div id='top'>
        <div class="container justify-between  mb-0 overflow-hidden">  
            <div class='md:w-1/2 w-full float-left mb-1'>
                <a class='wellcome md:inline' href="/">
                HocCode.net <span class="text-xs italic">- Chia sẽ kiến thức công nghệ</span>
                </a>    
            </div>
            
            <div class="md:w-1/2 w-full  float-right">
                @auth
                    @if(auth()->user()->unreadNotifications->count()>0)
                        <a href="{{route('winPrizeNotification.list')}}"><i class="fas fa-bell"></i> <span class='totalItem'>[<span id='totalNotification'>{{auth()->user()->unreadNotifications->count()}}</span>]</span></a>
                    @endif
                @endauth
    
                @include('laravellayout::template.LaravelPost.Component.account') 
                @include('laravellayout::template.LaravelPost.Component.formSearch') 
            </div> 
        </div>
    </div> 
    <!-- bg-Top -->
 

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

                @foreach($data['threads'] as $thread)
                <li>
                    @if(count($data['childs'][$thread->id])>0)
                    <a href="javascript:;">
                        <i class="fa fa-cube" aria-hidden="true"></i>
                        <span class="title">{{$thread->title}}</span>
                        <span class="arrow"></span> 
                    </a>
                    @else
                    <a href="{{route('thread.showSlug',['slug'=>$thread->slug])}}">
                        <i class="fa fa-cube" aria-hidden="true"></i>
                        <span class="title">{{$thread->title}}</span> 
                    </a>
                    @endif
                    <!-- Level Two-->
                    <ul>
                        @foreach($data['childs'][$thread->id] as $child)
                        <li>
                            <a href="{{route('thread.showSlug',['slug'=>$child->slug])}}">{{$child->title}}</a>
                        </li> 
                        @endforeach
                    </ul>
                </li>
                @endforeach
 
                <li class="last ">
                    <a href="{{route('aboutUs')}}">
                        <i class="fas fa-receipt"></i>
                        <span class="title">
                            {{$data['aboutUs']->title}}
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
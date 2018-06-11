<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('admin.home') }}" class="logo"
       style="font-size: 16px;">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
           @lang('neev::global.global_title')</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
           @lang('neev::global.global_title')</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li><a href="{{ route('user.home') }}"><span>{{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}}</span></a></li>
                    <li><a href="#logout" onclick="$('#logout').submit();">@lang('neev::user.logout')</a></li>
                </ul>
            </div>

    </nav>
</header>  
{{--  <div class="top_nav">
    <div class="nav_menu">
      <nav>
        <div class="nav toggle">
          <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <ul class="nav navbar-nav navbar-right">
          <li role="presentation" class="dropdown">
            <a href="#logout" onclick="$('#logout').submit();" aria-expanded="false" >@lang('neev::user.logout')</a>
        </li>
          <li class="">
            <a href="{{ route('user.home') }}" class="user-profile"  aria-expanded="false" ><span>{{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}}</span></a>
          </li>
        </ul>
      </nav>
    </div>
  </div>   --}}
  <!-- /top navigation -->

{!! Form::open(['route' => 'logout', 'style' => 'display:none;', 'id' => 'logout']) !!} {!! Form::close() !!}

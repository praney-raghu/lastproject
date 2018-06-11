<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo" style="font-size: 16px;">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">User</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">User Area</span>
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

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-top: 5px;padding-bottom: 5px; text-align:center">
                        <!-- <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> -->
                        <span class="hidden-xs" >{{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}}</span><br>
                        <span class="hidden-xs" style="text-align:center">{{  Auth::user()->getOrganisationAttribute()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        
                            <p>
                                {{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}}
                                
                            </p>
                        </li>
                        <!-- Menu Body -->
                        @if (count(Auth::user()->organisationsOrdered) > 5)
                            <li class="user-body">
                                <input type="text" id="myInput" onkeyup="searchFunction()" placeholder="Search for names.." style="width:100%; border-radius: 10px;" title="Type in a name">
                            </li>
                        @endif         
                        <li class="user-body">
                            <ul id="myUL"> 
                                @foreach (Auth::user()->organisationsOrdered as $user_org)
                                    <li><p>
                                    @if (is_null(Auth::user()->organisationsOrdered) || auth()->user()->organisation->getKey() !== $user_org->getKey())
                                        <a href="{{route('organisation.switchSameView', $user_org)}}"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;</a>{{ $user_org->name }}
                                    @else
                                        {{ $user_org->name }}<span class="glyphicon glyphicon-ok pull-right"></span>  
                                    @endif    
                                </p></li>
                                @endforeach    
                            </ul>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('user.profile') }}" class="btn btn-default btn-flat">@lang('neev::user.personal_details')</a>
                            </div>
                            <div class="pull-right">
                                <a href="#logout" class="btn btn-default btn-flat" onclick="$('#logout').submit();">@lang('neev::user.logout')</a>
                            </div>
                        </li>
                    </ul>
                </li>

                @if(auth()->user()->isAdmin())
                <li>
                    <a href="{{ route('admin.home') }}" class="btn btn-logged-in-admin" data-toggle="tooltip" data-placement="bottom" title=""
                        data-original-title="You are currently logged in as an admin. Click here to return to Admin Area">
                        <i class="fa fa-shield" aria-hidden="true"></i>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </nav>
</header>

{!! Form::open(['route' => 'logout', 'style' => 'display:none;', 'id' => 'logout']) !!} {!! Form::close() !!}  

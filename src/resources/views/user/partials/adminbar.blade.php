@if( auth()->guard('admin')->check() && (!auth()->guard()->check() || auth()->user()->id != auth('admin')->user()->id ) )

<nav class="navbar navbar-inverse" style="margin-bottom:0; z-index:99999; background-color: rgb(39, 39, 39); border-radius: 0px;" >

  <div class="container-fluid">
    <ul class="nav navbar-nav">
      <li>
        <a href="#"><i class="fa fa-user-secret" aria-hidden="true"></i></a>
      </li>
    </ul>
    
    <ul class="nav navbar-nav" style="">
      <li><div style="color: white; font-size: 14px; padding: 15px;" >
          <strong>You are masquerading as <b>
            @if(auth()->guard()->check())
              {{ auth()->user()->name }}
            @else
              Guest
            @endif</b>
          </strong>
          </div>
        </li>    
    </ul>
    <ul class="nav navbar-nav" style="">
      <li><a href="{{ route('admin.stopImpersonation') }}">Stop Impersonating</a></a></li>
    </ul>
    <ul class="nav navbar-nav">
        @if(auth()->guard()->check())
        <li>
          <a href="{{ route('admin.impersonateGuest') }}">View as Guest</a>
        </li>
      @endif
    </ul>

    <ul class="nav navbar-nav" style="float:right;">
      <li><a href="{{ route('admin.home') }}">Go to Admin Panel</a></li>
    </ul>
    
  </div>
</nav>
  
@endif

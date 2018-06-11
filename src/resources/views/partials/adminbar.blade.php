@if( auth()->guard('admin')->check() && (!auth()->guard()->check() || auth()->user()->id != auth('admin')->user()->id ) )

<nav class="navbar navbar-inverse" style="margin-bottom:0; z-index:99999; background-color: rgb(39, 39, 39); border-radius: 0px;" >

  <div class="container-fluid">
    <ul class="nav navbar-nav">
      
      <li>
        <a href="#"><i class="fa fa-user-secret" aria-hidden="true"></i></a>
      </li>

        <li>  
          <div style="color: white; font-size: 14px; padding: 15px;" >
              <strong>You are masquerading as <b>
                @if(auth()->guard()->check())
                  {{ auth()->user()->name }}
                @else
                  Guest
                @endif</b>!
              </strong> 
          </div>
        </li>
        <li><a href="{{ route('admin.stopImpersonation') }}">Stop Impersonating</a></li>

        @if(auth()->guard()->check())
          <li>
            <a href="{{ route('admin.impersonateGuest') }}">View as Guest</a>
          </li>
        @endif

{{--        <form role="form" method="POST" action="{{ route('admin.impersonateUser') }}"></form>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <li><label>View as </label></li>
          <li style="padding: 5px;">
            <select class="form-control" id="sel" name="user">
              @foreach(auth('admin')->user()->owner->users as $u)
                @if($u->id != auth('admin')->user()->id)
                  <option value="{{$u->id}}">{{ $u->name }}</option>
                @endif
              @endforeach
            </select>
          </li>
          <li style="padding: 5px;">
            <button type="submit" class="btn btn-primary">Impersonate</button>
          </li>
          <li><a href="{{ route('admin.impersonateGuest') }}">View as Guest</a></li>
        </form>
--}}

    </ul>

    <ul class="nav navbar-nav" style="float:right;">
      <li><a href="{{ route('admin.home') }}">Go to Admin Panel</a></li>
    </ul>
    
  </div>
</nav>
  
@endif

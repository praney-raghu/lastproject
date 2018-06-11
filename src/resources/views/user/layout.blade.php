<!DOCTYPE html>
<html lang="en">

<head>
    @include('neev::user.partials.head')
</head>


<body class="hold-transition skin-green sidebar-mini">
        @include('neev::user.partials.sidebar')


<div id="wrapper">
        @include('neev::user.partials.adminbar')
        @include('neev::user.partials.topbar')


<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            @if(isset($siteTitle))
                <h3 class="page-title">
                    {{ $siteTitle }}
                </h3>
            @endif

            <div class="row">
                <div class="col-md-12">

                    @if (Session::has('message'))
                        <div class="note note-info">
                            <p>{{ Session::get('message') }}</p>
                        </div>
                    @endif
                    @if ($errors->count() > 0)
                        <div class="note note-danger">
                            <ul class="list-unstyled">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')

                </div>
            </div>
        </section>
    </div>
</div>

{!! Form::open(['route' => 'logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit">Logout</button>
{!! Form::close() !!}

@include('neev::user.partials.javascripts')
</body>
</html>
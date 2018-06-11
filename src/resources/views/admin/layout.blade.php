<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>
        @yield('page_title')
    </title>
    
    {{--  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">  --}}
    
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js does not work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
     
    <link rel="stylesheet" href="{{ url('adminlte/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ url('adminlte/css') }}/select2.min.css" />
    <link rel="stylesheet" href="{{ url('adminlte/css/AdminLTE.min.css') }}" />
    <link rel="stylesheet" href="{{ url('adminlte/css/skins/skin-purple-light.min.css') }}" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.0/css/select.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.standalone.min.css" />  
    
    {{-- 
    <link href="{{ url('gentelella/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ url('gentelella/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- Select2-->
    <link href="{{ url('gentelella/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ url('gentelella/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ url('gentelella/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.5/css/select.dataTables.min.css" />

    <!-- bootstrap-progressbar -->
    <link href="{{ url('gentelella/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ url('gentelella/vendors/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{ url('gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.0/css/select.dataTables.min.css" />
    <!-- datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />
    <link href="{{ url('gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">  
    <link href="{{ url('gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- Custom Theme Style -->
    <link href="{{ url('gentelella/build/css/custom.min.css') }}" rel="stylesheet">  --}}
</head>


<body class="hold-transition skin-purple-light sidebar-mini">  
{{--  <body class="nav-md">  
<div  class="container body"> --}}
    <div id="wrapper" >
        @include('neev::admin.partials.topbar')
        @include('neev::admin.partials.sidebar')

<!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" role="main" style="min-height: 1672px;">    
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
        <footer>
            <div class="pull-right">
            </div>
            <div class="clearfix"></div>
        </footer>
    <!-- </div> -->
</div>
{!! Form::open(['route' => 'logout', 'style' => 'display:none;', 'id' => 'logout1']) !!}
<button type="submit">Logout</button>
{!! Form::close() !!}

<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
<script src="{{ url('adminlte/js') }}/bootstrap.min.js"></script>
<script src="{{ url('adminlte/js') }}/select2.full.min.js"></script>
<script src="{{ url('adminlte/js') }}/main.js"></script>

<script src="{{ url('adminlte/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/fastclick/fastclick.js') }}"></script>
<script src="{{ url('adminlte/js/app.min.js') }}"></script>  

{{-- 
<!-- jQuery -->
    <script src="{{ url('gentelella/vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ url('gentelella/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ url('gentelella/vendors/select2/dist/js/select2.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ url('gentelella/vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ url('gentelella/vendors/nprogress/nprogress.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ url('gentelella/vendors/iCheck/icheck.min.js') }}"></script>

    <!-- bootstrap-daterangepicker -->
    <script src="{{ url('gentelella/vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ url('gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    

    <!-- Datatables -->
    <script src="{{ url('gentelella/vendors/jszip/dist/jszip.min.js') }}"></script>
    <script src="{{ url('gentelella/vendors/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ url('gentelella/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ url('gentelella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('gentelella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ url('gentelella/vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ url('gentelella/vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ url('gentelella/vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ url('gentelella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ url('gentelella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ url('gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
    <script src="{{ url('gentelella/vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
    <script src="{{ url('gentelella/vendors/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="https://cdn.datatables.net/select/1.2.5/js/dataTables.select.min.js"></script>


    <!-- Custom Theme Scripts -->
    <script src="{{ url('gentelella/build/js/custom.min.js') }}"></script>  --}}

<script>
    window._token = '{{ csrf_token() }}';
</script> 
@yield('javascript')
</body>
</html>
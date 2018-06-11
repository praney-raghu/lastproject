@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        {{--<ul class="sidebar-menu">
            
            <li class="{{ $request->is('home*') ? 'active' : '' }}">
                <a href="{{ route('organisation.home') }}">
                    <i class="fa fa-wrench"></i>
                    <span class="title">{{trans('global.app_dashboard')}}</span>
                </a>
            </li>

        </ul>--}}
        {!! $ClientMenu->asUl(['class' => 'sidebar-menu'],['class' => 'treeview-menu']) !!}
    </section>
</aside>


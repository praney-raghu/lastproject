@inject('request', 'Illuminate\Http\Request')
<aside class="main-sidebar">
    <section class="sidebar">
    {{--    <ul class="sidebar-menu">
            <li class="{{ $request->is('*/home*') ? 'active' : '' }}">
                <a href="{{ route('user.home') }}">
                 <i class="fa fa-dashboard"></i><span class="title">{{trans('global.app_dashboard')}}</span>
                 </a>
            </li>
            <li class="treeview">
                <a href="#" > <i class="fa fa-laptop"></i><span class="title">{{trans('global.app_account_settings')}}</span></a>
                <ul class="treeview-menu">
                    <li class="{{ $request->is('*/profile*') ? 'active active-sub' : '' }}">
                        <a href="{{ route('user.profile') }}">
                            <i class="fa fa-user"></i>
                                <span class="title">{{trans('global.profile')}}</span>
                        </a>
                    </li>
                    <li class="{{ $request->is('*/change_password*') ? 'active active-sub' : '' }}">
                        <a href="{{ route('user.change_password') }}">
                            <i class="fa fa-key"></i>
                            <span class="title">{{trans('global.change_password')}}</span>
                        </a>
                    </li>                                           
                    <li class="{{ $request->is('*/organisation*') ? 'active active-sub' : '' }}">
                        <a href="{{ route('organisation.index') }}">
                            <i class="fa fa-user"></i>
                                <span class="title">{{trans('global.organisations')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ $request->is('*/language*') ? 'active' : '' }}">
                <a href="{{ route('language.index') }}">
                    <i class="fa fa-wrench"></i>
                    <span class="title">{{trans('global.app_languages')}}</span>
                </a>
            </li>
        </ul>   --}}
        {!! $UserMenu->asUl(['class' => 'sidebar-menu'],['class' => 'treeview-menu']) !!}
    </section>
</aside>
    
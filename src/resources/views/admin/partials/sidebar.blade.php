@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
    {{--    <ul class="sidebar-menu">     
                    <li class="{{ $request->is('manage*') ? 'active' : '' }}">
                    <a href="{{ route('admin.home') }}">
                        <i class="fa fa-wrench"></i>
                        <span class="title">{{trans('global.app_dashboard')}}</span>
                    </a> 
                    </li>    
                @can('manage_users') 
                    <li class="treeview">
                        <a href="#"><i class="fa fa-users"></i> <span class="title">@lang('neev::global.user-management.title')</span></a>
                        <ul class="treeview-menu">
                            <li class="{{ $request->is('*/users*') ? 'active active-sub' : '' }}">
                            <a href="{{ route('admin.users.index') }}">
                                <i class="fa fa-user"></i>
                                <span class="title">
                                @lang('neev::global.users.title')
                                </span>
                                </a>
                            </li>    
                            <li class="{{ $request->is('*/clients*') ? 'active active-sub' : '' }}">
                            <a href="{{ route('admin.clients.index') }}">
                                <i class="fa fa-user"></i>
                                <span class="title">
                                    Clients
                                </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @auth('admin')
                    <li class="treeview">
                    <a href="#"><i class="fa fa-gear"></i>
                        <span class="title">@lang('neev::admin.left_menu_title')</span>
                    </a>
                        <ul class="treeview-menu">
                    @can('manage_permissions')
                            <li class="{{ $request->is('*/permissions*') ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.permissions.index') }}">
                                    <i class="fa fa-briefcase"></i>
                                <span class="title">
                                @lang('neev::global.permissions.title')
                                </span>
                                </a>
                            </li>
                            <li class="{{ $request->is('*/roles*') ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.roles.index') }}">
                                <i class="fa fa-briefcase"></i>
                                <span class="title">
                                @lang('neev::global.roles.title')
                                </span>
                                </a>
                            </li>
                    @endcan
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-user"></i>
                            <span class="title">{{trans('global.catalogue')}}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ $request->is('*/products*') ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.product.index') }}">
                                    <i class="fa fa-user"></i>
                                    <span class="title">
                                        {{trans('global.products')}}
                                    </span>
                                </a>
                            </li>
                            <li class="{{ $request->is('*/category*') ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.category.index') }}">
                                    <i class="fa fa-user"></i>
                                    <span class="title">
                                        {{trans('global.category')}}
                                    </span>
                                </a>
                            </li>                            
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-user"></i>
                            <span class="title">{{trans('global.order')}}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ $request->is('*/orders*') ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.order.index') }}">
                                    <i class="fa fa-user"></i>
                                    <span class="title">
                                        {{trans('global.order')}}
                                    </span>
                                </a>
                            </li>
                            <li class="{{ $request->is('*/invoices*') ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.invoice.index') }}">
                                    <i class="fa fa-user"></i>
                                    <span class="title">
                                        {{trans('global.invoice')}}
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ $request->is('*/translation*') ? 'active' : '' }}">
                        <a href="{{ route('admin.translation.index') }}">
                            <i class="fa fa-wrench"></i>
                            <span class="title">{{trans('global.app_translations')}}</span>
                        </a>
                    </li>
                    <li class="{{ $request->is('*/dynamicmenu*') ? 'active' : '' }}">
                        <a href="{{ url('/dynamicmenu') }}">
                            <i class="fa fa-wrench"></i>
                            <span class="title">Dynamic Menu</span>
                        </a>
                    </li>
            @endauth
                </ul>  --}}

                {!! $AdminMenu->asUl(['class' => 'sidebar-menu'],['class' => 'treeview-menu']) !!}
                        
    </section>
</aside>



      

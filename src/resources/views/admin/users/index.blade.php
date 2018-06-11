@inject('request', 'Illuminate\Http\Request')
@extends('neev::admin.layout')

@section('page_title')
    @if(isset($siteTitle))
        {{ $siteTitle }}
    @else
         @lang('neev::global.users.title') - {{ trans('neev::global.global_title') }}
    @endif
@endsection

@section('content')
    <h3 class="page-title">@lang('neev::global.users.title')</h3>
    <p>
        <a href="{{ route('admin.users.create') }}" class="btn btn-success">@lang('neev::global.app_add_new')</a>
    </p>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('neev::global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-striped table-bordered {{ count($users) > 0 ? 'datatable' : '' }} dt-select" id="datatable-buttons">
                <thead>
                    <tr>
                        <th style="text-align:center;"><input type="checkbox" id="select-all" class=""/></th>
                        <th>@lang('neev::global.users.fields.name')</th>
                        <th>@lang('neev::global.users.fields.email')</th>
                        <th>@lang('neev::global.users.fields.roles')</th>
                        <th>&nbsp;</th>
                        @can('impersonate')
                        <th>&nbsp;</th>
                        @endcan
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($users) > 0)
                        @foreach ($users as $user)
                            <tr data-entry-id="{{ $user->id }}">
                                <td style="text-align:center;">
                                    
                                  </td>

                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach ($user->roles()->pluck('name') as $role)
                                        <span  class="label label-info label-many">{{ $role }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.edit',[$user->id]) }}" class="btn btn-xs btn-info" style="float:left;">@lang('neev::global.app_edit')</a>&nbsp;
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("neev::global.app_are_you_sure")."');",
                                        'route' => ['admin.users.destroy', $user->id])) !!}
                                    {!! Form::submit(trans('neev::global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                </td>
                                @can('impersonate')
                                <td>
                                    <a href="{{ route('admin.impersonateUser', [$user->id]) }}">
                                        <i class="fa fa-user-secret" aria-hidden="true"></i>
                                    </a>
                                </td>
                                @endcan
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9">@lang('neev::global.app_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
                {{--  <div class="actions"></div>  --}}
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        window.route_mass_crud_entries_destroy = '{{ route('admin.users.mass_destroy') }}';
    </script>
@endsection
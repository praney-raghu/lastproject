@inject('request', 'Illuminate\Http\Request')
@extends('neev::admin.layout')

@section('page_title')
    @if(isset($siteTitle))
        {{ $siteTitle }}
    @else
         @lang('neev::global.roles.title') - {{ trans('neev::global.global_title') }}
    @endif
@endsection

@section('content')
    <h3 class="page-title">@lang('neev::global.roles.title')</h3>
    <p>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-success">@lang('neev::global.app_add_new')</a>
    </p>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('neev::global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($roles) > 0 ? 'datatable' : '' }} dt-select" id="datatable-buttons">
                <thead>
                    <tr>
                        <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        <th>@lang('neev::global.roles.fields.name')</th>
                        <th>@lang('neev::global.roles.fields.permission')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($roles) > 0)
                        @foreach ($roles as $role)
                            <tr data-entry-id="{{ $role->id }}">
                                <td></td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @foreach ($role->permissions()->pluck('name') as $permission)
                                        <span class="label label-info label-many">{{ $permission }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('admin.roles.edit',[$role->id]) }}" class="btn btn-xs btn-info" style="float:left">@lang('neev::global.app_edit')</a>
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("neev::global.app_are_you_sure")."');",
                                        'route' => ['admin.roles.destroy', $role->id])) !!}
                                    {!! Form::submit(trans('neev::global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">@lang('neev::global.app_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        window.route_mass_crud_entries_destroy = '{{ route('admin.roles.mass_destroy') }}';
    </script>
@endsection
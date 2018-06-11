@inject('request', 'Illuminate\Http\Request')
@extends('neev::admin.layout')

@section('page_title')
    @if(isset($siteTitle))
        {{ $siteTitle }}
    @else
         @lang('neev::global.clients.title') - {{ trans('neev::global.global_title') }}
    @endif
@endsection

@section('content')
    <h3 class="page-title">@lang('neev::global.clients.title')</h3>
    <p>
        <a href="{{ route('admin.clients.create') }}" class="btn btn-success">@lang('neev::global.app_add_new')</a>
    </p>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('neev::global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($clients) > 0 ? 'datatable' : '' }} dt-select" id="datatable-buttons">
                <thead>
                    <tr>
                        <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>

                        <th>@lang('neev::global.clients.fields.name')</th>
                        <th>@lang('neev::global.clients.fields.email')</th>
                        <th>@lang('neev::global.clients.fields.roles')</th>
                        <th>&nbsp;</th>

                    </tr>
                </thead>
                
                <tbody>
                    @if (count($clients) > 0)
                        @foreach ($clients as $client)
                            <tr data-entry-id="{{ $client->id }}">
                                <td></td>

                                <td>{{ $client->name }}</td>
                                <td>{{ $client->email }}</td>
                                <td>
                                    @foreach ($client->roles()->pluck('name') as $role)
                                        <span class="label label-info label-many">{{ $role }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('admin.clients.edit',[$client->id]) }}" class="btn btn-xs btn-info" style="float:left">@lang('neev::global.app_edit')</a>
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("neev::global.app_are_you_sure")."');",
                                        'route' => ['admin.clients.destroy', $client->id])) !!}
                                    {!! Form::submit(trans('neev::global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9">@lang('neev::global.app_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        window.route_mass_crud_entries_destroy = '{{ route('admin.clients.mass_destroy') }}';
    </script>
@endsection
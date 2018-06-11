@extends('neev::admin.layout')

@section('page_title')
    @if(isset($siteTitle))
        {{ $siteTitle }}
    @else
        @lang('neev::global.app_dashboard') - {{ trans('neev::global.global_title') }}
    @endif
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
@endsection

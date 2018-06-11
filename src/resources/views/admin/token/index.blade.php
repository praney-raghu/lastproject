@extends('neev::admin.layout')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">Tokens</div>

                <div class="panel-body">
                    <div id="app">
                        <passport-clients></passport-clients>
                        <passport-authorized-clients></passport-authorized-clients>
                        <passport-personal-access-tokens></passport-personal-access-tokens>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="{{asset('js/app.js')}}"></script>

@endsection

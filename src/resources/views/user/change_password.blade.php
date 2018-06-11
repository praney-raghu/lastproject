@extends('neev::user.layout')

@section('content')
    <h3 class="page-title">Change password</h3>
    <br>
    @if(session('success'))
        <!-- If password successfully show message -->
        <div class="row">
            <div class="col-md-4">
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            </div>    
        </div>
    @endif 
    @if(session('failure'))
        <!-- If password successfully show message -->
        <div class="row">
            <div class="col-md-4">
                <div class="alert alert-danger text-center">
                    {{ session('failure') }}
                </div>
            </div>    
        </div>
    @endif    
        {!! Form::open(['method' => 'PATCH', 'route' => ['user.change_password']]) !!}
        <!-- If no success message in flash session show change password form  -->
        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('neev::global.app_edit')
            </div>

            <div class="content mt-3">
                <div class="row">
                    <div class="col-xs-12 form-group">
                        {!! Form::label('current_password', 'Current password*', ['class' => 'control-label']) !!}
                        {!! Form::password('current_password', ['class' => 'form-control', 'placeholder' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('current_password'))
                            <p class="help-block">
                                {{ $errors->first('current_password') }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 form-group">
                        {!! Form::label('new_password', 'New password*', ['class' => 'control-label']) !!}
                        {!! Form::password('new_password', ['class' => 'form-control', 'placeholder' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('new_password'))
                            <p class="help-block">
                                {{ $errors->first('new_password') }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 form-group">
                        {!! Form::label('new_password_confirmation', 'New password confirmation*', ['class' => 'control-label']) !!}
                        {!! Form::password('new_password_confirmation', ['class' => 'form-control', 'placeholder' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('new_password_confirmation'))
                            <p class="help-block">
                                {{ $errors->first('new_password_confirmation') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {!! Form::submit(trans('neev::global.app_save'), ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    
@stop


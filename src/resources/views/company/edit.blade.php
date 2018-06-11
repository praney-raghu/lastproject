@extends('neev::layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit: {{Auth::user()->organisation->name}}</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="#">
	                    <input type="hidden" name="_method" value="PUT" />
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ old('name', Auth::user()->organisation->name) }}" >

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Address</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="address" value="{{ old('address') }}" >

                                @if ($errors->has('address'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">State</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="state" value="{{ old('state') }}" >

                                @if ($errors->has('state'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('state') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Country</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="country" value="{{ old('country') }}" >

                                @if ($errors->has('country'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('country') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('zip') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Zip</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="zip" value="{{ old('zip') }}" >

                                @if ($errors->has('zip'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('zip') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('taxcode_name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Taxcode name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="taxcode_name" value="{{ old('taxcode_name') }}" >

                                @if ($errors->has('taxcode_name'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('taxcode_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('taxcode_number') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Taxcode number</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="taxcode_number" value="{{ old('taxcode_number') }}" >

                                @if ($errors->has('taxcode_number'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('taxcode_number') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label"></label>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Update
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

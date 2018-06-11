@extends('neev::admin.layout')

@section('content')
    
    <div class="row">
        <div class="col-md-12 col-sm-12">
            @foreach($errors as $error)
            <span class="help-block">
                <strong>{{ $error }}</strong>
            </span>
            @endforeach
            <div class="panel panel-default">
                <div class="panel-heading clearfix">Add a new category
                    <button type="submit" class="pull-right btn btn-primary" form="new-category">
                        <i class="fa fa-save"></i> Save
                    </button>
                </div>
                <div class="panel-body">

                    <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#general">General</a></li>
                    <li><a data-toggle="tab" href="#data">Data</a></li>
                    </ul>

                    <form id="new-category" class="form-horizontal" method="post" action="{{route('admin.category.store')}}">
	                        {!! csrf_field() !!}
                    <div class="tab-content">
	                    <div id="general" class="tab-pane fade in active">
	                    
	                        &nbsp;
	                        <div class="form-group{{ $errors->has('parent_id') ? ' has-error' : '' }}">
	                            <label class="col-md-4 control-label">Parent ID</label>

	                            <div class="col-md-6">
	                                <input type="text" class="form-control" name="parent_id" value="{{ old('parent_id') }}" >

	                                @if ($errors->has('parent_id'))
	                                    <span class="help-block">
	                                    <strong>{{ $errors->first('parent_id') }}</strong>
	                                </span>
	                                @endif
	                            </div>
	                        </div>

	                        <div class="form-group{{ $errors->has('sort_order') ? ' has-error' : '' }}">
	                            <label class="col-md-4 control-label">Sort Order</label>

	                            <div class="col-md-6">
	                                <input type="text" class="form-control" name="sort_order" value="{{ old('sort_order') }}" required>

	                                @if ($errors->has('sort_order'))
	                                    <span class="help-block">
	                                    <strong>{{ $errors->first('sort_order') }}</strong>
	                                </span>
	                                @endif
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <label class="col-md-4 control-label">Visible</label>

	                            <div class="col-md-6">
	                                <label class="radio-inline"><input type="radio" name="visible" checked value="1" required>Yes</label>
	                                <label class="radio-inline"><input type="radio" name="visible" value="0" required>No</label>
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <label class="col-md-4 control-label">Active</label>

	                            <div class="col-md-6">
	                                <label class="radio-inline"><input type="radio" name="active" checked value="1" required>Yes</label>
	                                <label class="radio-inline"><input type="radio" name="active" value="0" required>No</label>
	                            </div>
	                        </div>
                    	</div>
                    
                    <div id="data" class="tab-pane fade">
                    &nbsp;
                        <ul class="nav nav-tabs">
                        @foreach($languages as $description => $code)
                        <li><a data-toggle="tab" href="#{{$code}}">{{$description}}</a></li>
                        @endforeach
                        </ul>

                        <div class="tab-content">
                        @foreach($languages as $description => $code)
                        <div id="{{$code}}" class="tab-pane fade">
                        	&nbsp;
                            <div class="form-group">
                                <label class="col-md-4 control-label">Name<span style="color:red;"> *</span></label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name_{{$code}}" value="{{ old('name') }}" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Description<span style="color:red;"> *</span></label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="description_{{$code}}" value="{{ old('description') }}" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Meta description<span style="color:red;"> *</span></label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="meta_description_{{$code}}" value="{{ old('meta_description') }}" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Meta keyword<span style="color:red;"> *</span></label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="meta_keyword_{{$code}}" value="{{ old('meta_keyword') }}" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Slug<span style="color:red;"> *</span></label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="slug_{{$code}}" value="{{ old('slug') }}" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Tag<span style="color:red;"> *</span></label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="tag_{{$code}}" value="{{ old('tag') }}" >
                                </div>
                            </div>
                        </div>
                        @endforeach                        
                        </div>                       
                    </div>
                    </div>

                    </form> 
                </div>
            </div>
        </div>
    </div>
@endsection

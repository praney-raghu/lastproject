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
                <div class="panel-heading clearfix">Edit Category
                    <button type="submit" class="pull-right btn btn-primary" form="edit-category">
                        <i class="fa fa-save"></i> Update
                    </button>
                </div>
                <div class="panel-body">

                    <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#general">General</a></li>
                    <li><a data-toggle="tab" href="#data">Data</a></li>
                    </ul>

                    <form id="edit-category" class="form-horizontal" method="post" action="{{route('admin.category.update', $category)}}">
	                        <input type="hidden" name="_method" value="PUT" />
                            {!! csrf_field() !!}
                    <div class="tab-content">
	                    <div id="general" class="tab-pane fade in active">
	                    
	                        &nbsp;
	                        <div class="form-group{{ $errors->has('parent_id') ? ' has-error' : '' }}">
	                            <label class="col-md-4 control-label">Parent ID</label>

	                            <div class="col-md-6">
	                                <input type="text" class="form-control" name="parent_id" value="{{ old('parent_id', $category->parent_id) }}" >

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
	                                <input type="text" class="form-control" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" required>

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
	                                <label class="radio-inline"><input type="radio" name="visible" value="1" required {{ $category->visible == '1' ? 'checked' : '' }}>Yes</label>
	                                <label class="radio-inline"><input type="radio" name="visible" value="0" required {{ $category->visible == '0' ? 'checked' : '' }}>No</label>
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <label class="col-md-4 control-label">Active</label>

	                            <div class="col-md-6">
	                                <label class="radio-inline"><input type="radio" name="active" value="1" required {{ $category->active == '1' ? 'checked' : '' }}>Yes</label>
	                                <label class="radio-inline"><input type="radio" name="active" value="0" required {{ $category->active == '0' ? 'checked' : '' }}>No</label>
	                            </div>
	                        </div>
                    	</div>
                    
                    <div id="data" class="tab-pane fade">
                    &nbsp;
                        <ul class="nav nav-tabs">
                        @foreach($category->languages as $description => $code)
                        <li><a data-toggle="tab" href="#{{$code}}">{{$description}}</a></li>
                        @endforeach
                        </ul>

                        <div class="tab-content">
                        @foreach($category->languages as $description => $code)
                        <div id="{{$code}}" class="tab-pane fade">
                        	&nbsp;
                            <div class="form-group">
                                <label class="col-md-4 control-label">Name<span style="color:red;"> *</span></label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name_{{$code}}" value="{{ $category->getTranslation('name',$code) }}" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Description<span style="color:red;"> *</span></label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="description_{{$code}}" value="{{ $category->getTranslation('description',$code) }}" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Meta description<span style="color:red;"> *</span></label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="meta_description_{{$code}}" value="{{ $category->getTranslation('meta_description',$code) }}" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Meta keyword<span style="color:red;"> *</span></label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="meta_keyword_{{$code}}" value="{{ $category->getTranslation('meta_keyword',$code) }}" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Slug<span style="color:red;"> *</span></label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="slug_{{$code}}" value="{{ $category->getTranslation('slug',$code) }}" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Tag<span style="color:red;"> *</span></label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="tag_{{$code}}" value="{{ $category->getTranslation('tag',$code) }}" >
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

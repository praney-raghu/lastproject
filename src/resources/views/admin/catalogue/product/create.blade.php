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
                <div class="panel-heading clearfix">Add a new product
                    <button type="submit" class="pull-right btn btn-primary" form="new-product">
                        <i class="fa fa-save"></i> Save
                    </button>
                </div>
                <div class="panel-body">

                    <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#general">General</a></li>
                    <li><a data-toggle="tab" href="#data">Data</a></li>
                    </ul>

                    <form id="new-product" class="form-horizontal" method="post" action="{{route('admin.product.store')}}">
	                        {!! csrf_field() !!}
                    <div class="tab-content">
	                    <div id="general" class="tab-pane fade in active">
	                    
	                        &nbsp;
	                        <div class="form-group{{ $errors->has('hsn') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">HSN</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="hsn" value="{{ old('hsn') }}" required>

                                    @if ($errors->has('hsn'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('hsn') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

	                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Type</label>

                                <div class="col-md-6">                                
                                    <select name="type" class="form-control" required>
                                    <option value = "">Select Type </option> 
                                    @foreach($productType as $key => $value)   
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                    </select>
                                    @if ($errors->has('type'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('module') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Module</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="module" value="{{ old('module') }}" required>

                                    @if ($errors->has('module'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('module') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('cost') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Cost</label>

                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="cost" value="{{ old('cost') }}" required>

                                    @if ($errors->has('cost'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('cost') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Manage Inventory</label>

                                <div class="col-md-6">
                                    <label class="radio-inline"><input type="radio" name="optradio" checked value="1" required>Yes</label>
                                    <label class="radio-inline"><input type="radio" name="optradio" value="0" required>No</label>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('qty') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Quantity</label>

                                <div class="col-md-6">                               
                                    <input type="number" class="form-control" name="qty" id="qty" value="{{ old('qty') }}" required >

                                    @if ($errors->has('qty'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('qty') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('unit') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Unit</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="unit" value="{{ old('unit') }}" required>

                                    @if ($errors->has('unit'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('unit') }}</strong>
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
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
    $("input:radio[name=optradio]").click(function(){
        var selectedOption = $("input:radio[name=optradio]:checked").val();
        if(selectedOption == 0)
        {
            $("#qty").prop('required',false);
            $("#qty").prop('disabled',true);
            $("#qty").val("");
        }
        else
        {
            $("#qty").prop('required',true);
            $("#qty").prop('disabled',false);
        }
    });
});
</script>
@endsection
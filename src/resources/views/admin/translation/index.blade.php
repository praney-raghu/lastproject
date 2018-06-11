@extends('neev::admin.layout')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Translation Manager</div>
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#view-translation">View Translation</a></li>
                    <li><a data-toggle="tab" href="#set-translation">Set Translation</a></li>
                    </ul>

                    <div class="tab-content">
	                    <div id="view-translation" class="tab-pane fade in active">
                        &nbsp;
                                                
                        <form id="selectGroup" class="form-horizontal" method="post" action="{{route('admin.translation.getGroup')}}">
	                        {!! csrf_field() !!}
                            <div class="alert alert-info alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Choose a group to display the group translations. If no groups are visible, then default translations present in file are set.</strong>
                            </div>
                            
                            <div class="form-group{{ $errors->has('group_selected') ? ' has-error' : '' }}">
	                            <label class="col-md-4 control-label">Select Group</label>
	                            <div class="col-md-6">
	                                <select name="group_selected" class="form-control" required>
                                        <option value = "">Choose group </option> 
                                        @foreach($groups as $key => $value)   
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endforeach
                                    </select>
	                            </div>
	                        </div>
                            <div class="form-group">
                                <div class="col-md-offset-4 col-md-6">
                                    <button type="submit" class="btn btn-primary" form="selectGroup">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                        @if($keys != NULL)
                        &nbsp;
                        <div class="col-md-12 table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <div class="col-md-6">
                                            <th>Key</th>
                                        </div>
                                        @foreach($languages as $description => $code)
                                        <div class="col-md-6">
                                            <th>{{$description}}</th>
                                        </div>
                                        @endforeach                                        
                                    </tr>
                                </thead>
                                <tbody >                                    
                                    @foreach($keys as $k => $value)
                                    <tr>
                                    <div class="col-md-6">
                                        <th>{{$value}}</th>
                                    </div>
                                    @foreach($languages as $description => $code)
                                    <div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
                                       <div class="col-md-6">
                                        <td id="translationValue"><a href="#" data-type="text" data-placement="right" data-pk="{{$value}}_{{$code}}" data-title="Edit Translation">{{$values[$value]->$code}}</a></td>
                                       </div>
                                    @endforeach
                                    </tr>
                                    @endforeach                                    
                                </tbody>
                            </table> 
                        </div>
                        @endif
                        </div>
                        <div id="set-translation" class="tab-pane">
                        &nbsp;
                            <form class="form-horizontal" method="post" action="{{route('admin.translation.set')}}">
	                        {!! csrf_field() !!}
                                                        
                            <div class="form-group{{ $errors->has('group') ? ' has-error' : '' }}">
	                            <label class="col-md-4 control-label">Group</label>
	                            <div class="col-md-6">
	                                <input type="text" class="form-control" name="group" id="group" value="{{ old('group') }}" >
                                    @if ($errors->has('group'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('group') }}</strong>
                                    </span>
                                    @endif
                                </div>
	                        </div>
                            <div class="form-group{{ $errors->has('key') ? ' has-error' : '' }}">
	                            <label class="col-md-4 control-label">Key</label>
	                            <div class="col-md-6">
	                                <input type="text" class="form-control" name="key" id="key" value="{{ old('key') }}" >                                
                                    @if ($errors->has('key'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('key') }}</strong>
                                    </span>
                                    @endif
                                </div>
	                        </div>
                            @foreach($languages as $description => $code)
                            <div class="form-group{{ $errors->has('translation_'.$code) ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">{{$description }} ({{$code}})</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="translation_{{$code}}" >
                                    @if ($errors->has('translation_'.$code))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('translation_'.$code) }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            <div class="form-group">
                                <div class="col-md-offset-4 col-md-6">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')

<script src="{{ url('editable/js/bootstrap-editable.js') }}"></script>
<script src="{{ url('editable/css/bootstrap-editable.css') }}"></script>
<script type="text/javascript">
      
$(document).ready(function() {
    //toggle `popup` / `inline` mode
    $.fn.editable.defaults.mode = 'popup'; 

    $.fn.editable.defaults.params = function (params) {
    params._token = $("#_token").data("token");
    return params;
    };    
    
    //make translation editable
    $('#translationValue a').editable({
    url: "{{route('admin.translation.edit')}}",
    dataType: 'json',
    ajaxOptions:{
        type:'post'
    } ,
    success: function(data) {
        //alert(data);
    }, 
});
});
    </script>

@endsection




@extends('neev::user.layout')

@section('content')
    
    <div class="row">
        <div class="col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Select Language</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="{{route('language.set')}}">
                        {!! csrf_field() !!}
                        
                        <div class="form-group{{ $errors->has('lang') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Language</label>

                            <div class="col-md-6">                                
                                <select name="lang" class="form-control" required>
                                <option value = "">Select Language </option>                                   
                                @foreach($languages as $description => $code)
                                <option value = "{{$code}}">{{$description}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>              

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-save"></i> Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('neev::admin.layout')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">Module Management</div>

                <div class="panel-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Module Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>                            
                            @foreach($modules as $module)
                                <tr>
                                    <td>{{$module->name}}</td>
                                    <td>
                                        @if($module->enabled())
                                            <a href="{{route('admin.modules.update', $module)}}" class="btn btn-sm btn-danger">
                                                <i class="fa fa-gear"></i>  Disable
                                            </a>
                                        @else
                                            <a href="{{route('admin.modules.update', $module)}}" class="btn btn-sm btn-success">
                                                <i class="fa fa-gear"></i>  Enable 
                                            </a>
                                        @endif                                    
                                        &nbsp;                          
                                        <form style="display: inline-block;" action="{{route('admin.modules.destroy', $module)}}" method="post">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="_method" value="DELETE" />
                                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete</button>
                                        </form>                                       
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

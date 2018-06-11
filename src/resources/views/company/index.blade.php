@extends('neev::layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{Auth::user()->organisation->name}} Dashboard</div>

                <div class="panel-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Owner</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>                            
                            
                                <tr>
                                    <td>{{ Auth::user()->organisation->owner_id }}</td>
                                    <td>{{ Auth::user()->organisation->name }}</td>
                                    <td>{{ Auth::user()->organisation->code }}</td>
                                    <td>                                                                                   
                                        <a href="{{route('organisation.newedit')}}" class="btn btn-sm btn-default">
                                            <i class="fa fa-pencil"></i> Edit
                                        </a>                                 
                                    </td>
                                </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

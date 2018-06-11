@extends('neev::user.layout')

@section('content')    
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    Organisations
                    <a class="pull-right btn btn-default btn-sm" href="{{route('organisation.create')}}">
                        <i class="fa fa-plus"></i> Create organisation
                    </a>
                </div>
                <div class="panel-body">                    
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Status</th>
                                <th>Members</th>
                                <th></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>                            
                        @foreach($organisations as $organisation)
                                <tr>
                                    <td>{{$organisation->name}}</td>
                                    <td>{{$organisation->code}}</td>
                                    <td>
                                        @if(auth()->user()->isAdmin($organisation))
                                            <span class="label label-success">Admin</span>
                                        @else
                                            <span class="label label-primary">Member</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('organisation.members.show', $organisation)}}" class="btn btn-sm btn-default">
                                            <i class="fa fa-users"></i> Members
                                        </a>
                                    </td>
                                    <td>
                                        @if(is_null(auth()->user()->organisation) || auth()->user()->organisation->getKey() !== $organisation->getKey())
                                            <div class="col-md-4">
                                                <a href="{{route('organisation.switch', $organisation)}}" class="btn btn-sm btn-default">
                                                    <i class="fa fa-sign-in"></i> Switch
                                                </a>
                                            </div>
                                            
                                        @else
                                            <span class="label label-info">Current organisation</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(auth()->user()->isAdmin($organisation))                                            
                                            <a href="{{route('organisation.edit', $organisation)}}" class="btn btn-sm btn-default">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>                                    
                                            &nbsp;                          
                                            <form style="display: inline-block;" action="{{route('organisation.destroy', $organisation)}}" method="post">
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="_method" value="DELETE" />
                                                <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete</button>
                                            </form>                                            
                                        @endif
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

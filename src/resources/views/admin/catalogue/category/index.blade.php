@extends('neev::admin.layout')

@section('content')    
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    Category
                    <a class="pull-right btn btn-default btn-sm" href="{{route('admin.category.create')}}">
                        <i class="fa fa-plus"></i> Add category
                    </a>
                </div>
                <div class="panel-body">                    
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Organisation</th>
                                <th>Parent</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Meta Description</th>
                                <th>Meta Keyword</th>
                                <th>Slug</th>
                                <th>Tag</th>
                                <th>Sort Order</th>
                                <th>Visible</th>
                                <th>Active</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>                            
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{$category->organisation->name}}</td>
                                    <td>{{$category->parent_id}}</td>
                                    <td>{{$category->name}}</td>
                                    <td>{{$category->description}}</td>
                                    <td>{{$category->meta_description}}</td>
                                    <td>{{$category->meta_keyword}}</td>
                                    <td>{{$category->slug}}</td>
                                    <td>{{$category->tag}}</td>
                                    <td>{{$category->sort_order}}</td>
                                    <td>{{$category->visible}}</td>
                                    <td>{{$category->active}}</td>
                                    <td>                                                                                   
                                        <a href="{{route('admin.category.edit', $category)}}" class="btn btn-sm btn-default">
                                            <i class="fa fa-pencil"></i> Edit
                                        </a>                                    
                                        &nbsp;                          
                                        <form style="display: inline-block;" action="{{route('admin.category.destroy', $category)}}" method="post">
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

@extends('neev::admin.layout')

@section('content')    
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    Products of {{ auth()->user()->organisation->name }}
                    <a class="pull-right btn btn-default btn-sm" href="{{route('admin.product.create')}}">
                        <i class="fa fa-plus"></i> Add product
                    </a>
                </div>
                <div class="panel-body">                    
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>HSN</th>
                                <th>Type</th>
                                <th>Module</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Meta Description</th>
                                <th>Meta Keyword</th>
                                <th>Slug</th>
                                <th>Tag</th>
                                <th>Cost</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Visible</th>
                                <th>Active</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>                            
                            @foreach($products as $product)
                                <tr>
                                    <td>{{$product->hsn}}</td>
                                    <td>{{$product->type}}</td>
                                    <td>{{$product->module}}</td>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->description}}</td>
                                    <td>{{$product->meta_description}}</td>
                                    <td>{{$product->meta_keyword}}</td>
                                    <td>{{$product->slug}}</td>
                                    <td>{{$product->tag}}</td>
                                    <td>{{$product->cost}}</td>
                                    <td>{{$product->qty}}</td>
                                    <td>{{$product->unit}}</td>
                                    <td>{{$product->visible}}</td>
                                    <td>{{$product->active}}</td>
                                    <td>                                                                                   
                                        <a href="{{route('admin.product.edit', $product)}}" class="btn btn-sm btn-default">
                                            <i class="fa fa-pencil"></i> Edit
                                        </a>                                    
                                        &nbsp;                          
                                        <form style="display: inline-block;" action="{{route('admin.product.destroy', $product)}}" method="post">
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

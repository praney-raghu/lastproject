@extends('neev::admin.layout')

@section('content')    
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    Orders :: {{Neev::organisation()->name}}
                    <a class="pull-right btn btn-default btn-sm" href="{{route('admin.order.create')}}">
                        <i class="fa fa-plus"></i> Add order
                    </a>
                </div>
                <div class="panel-body">                    
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Parent</th>
                                <th>Status</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>HSN</th>
                                <th>Type</th>
                                <th>Cost</th>
                                <th>Quantity</th>
                                <th>Shippable</th>
                                <th>Recurring</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>                            
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{$order->parent_id}}</td>
                                    <td><span class="label label-info">{{$order->status}}</span></td>
                                    <td>{{$order->name}}</td>
                                    <td>{{$order->description}}</td>
                                    <td>{{$order->hsn}}</td>
                                    <td>{{$order->type}}</td>
                                    <td>{{$order->cost}}</td>
                                    <td>{{$order->qty}}</td>
                                    <td>{{$order->shippable}}</td>
                                    <td>{{$order->recurring}}</td>
                                    <td>                                                                                   
                                        <a href="{{route('admin.order.edit', $order->order_id)}}" class="btn btn-sm btn-default">
                                            <i class="fa fa-pencil"></i> Edit
                                        </a>                                    
                                        &nbsp;                          
                                        <form style="display: inline-block;" action="{{route('admin.order.destroy', $order)}}" method="post">
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

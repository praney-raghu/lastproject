@extends('neev::admin.layout')

@section('content')    
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    Invoices :: {{Neev::organisation()->name}}
                    <a class="pull-right btn btn-default btn-sm" href="{{route('admin.invoice.create')}}">
                        <i class="fa fa-plus"></i> Add invoice
                    </a>
                </div>
                <div class="panel-body">                    
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Invoice Number</th>
                                <th>Invoice Date</th>
                                <th>Due Date</th>
                                <th>Bill Name</th>
                                <th>Seller Name</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>                            
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td><span class="label label-info">{{$invoice->status}}</span></td>
                                    <td>{{$invoice->invoice_number}}</td>
                                    <td>{{$invoice->invoice_date}}</td>
                                    <td>{{$invoice->due_date}}</td>
                                    <td>{{$invoice->bill_name}}</td>
                                    <td>{{$invoice->seller_name}}</td>
                                    <td>{{$invoice->amount}}</td>
                                    <td>                                                                                   
                                        <a href="{{route('admin.invoice.edit', $invoice)}}" class="btn btn-sm btn-default">
                                            <i class="fa fa-pencil"></i> Edit
                                        </a>                                    
                                        &nbsp;                          
                                        <form style="display: inline-block;" action="{{route('admin.invoice.destroy', $invoice)}}" method="post">
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

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
            <div class="panel-heading clearfix">Edit Invoice</div>
            <div class="panel-body">
                <form class="form-horizontal" method="post" action="{{route('admin.invoice.update', $invoice)}}">
                <input type="hidden" name="_method" value="PUT" />
                    {!! csrf_field() !!}
                    <div class="col-md-12 col-sm-12">
                        <div class="col-md-6 pull-left">
                            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }} ">
                                <label class="col-md-4 control-label">Status</label>

                                <div class="col-md-8">
                                    <select class="form-control" name="status">
                                        <option selected value="Draft" >Draft</option>
                                        <option value="Unpaid" >Unpaid</option>
                                        <option value="Paid" >Paid</option>
                                        <option value="Partial" >Partial</option>
                                        <option value="Cancelled" >Cancelled</option>                                        
                                    </select>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('invoice_date') ? ' has-error' : '' }} ">
                                <label class="col-md-4 control-label">Invoice Date</label>

                                <div class="col-md-8">
                                    <input type="date" class="form-control" name="invoice_date" value="{{ old('invoice_date', $invoice->invoice_date) }}" required>

                                    @if ($errors->has('invoice_date'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('invoice_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('po_number') ? ' has-error' : '' }} ">
                                <label class="col-md-4 control-label">PO Number</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="po_number" value="{{ old('po_number', $invoice->po_number) }}" >

                                    @if ($errors->has('po_number'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('po_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 pull-right">
                            <div class="form-group{{ $errors->has('invoice_number') ? ' has-error' : '' }} ">
                                <label class="col-md-4 control-label">Invoice No.</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="invoice_number" value="{{ old('invoice_number', $invoice->invoice_number) }}" required>

                                    @if ($errors->has('invoice_number'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('invoice_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('due_date') ? ' has-error' : '' }} ">
                                <label class="col-md-4 control-label">Due Date</label>

                                <div class="col-md-8">
                                    <input type="date" class="form-control" name="due_date" value="{{ old('due_date', $invoice->due_date) }}" required>

                                    @if ($errors->has('due_date'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('due_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div> 
                                        
                    <div class="panel panel-info col-md-6 ">
                        <div class="panel-heading">Seller Info</div>
                        <div class="panel-body">
                            <div class="form-group{{ $errors->has('seller_name') ? ' has-error' : '' }}">
	                            <label class="col-md-4 control-label">Name</label>

	                            <div class="col-md-8">
	                                <input type="text" class="form-control" name="seller_name" value="{{ old('seller_name', $invoice->seller_name) }}" required>

	                                @if ($errors->has('seller_name'))
	                                    <span class="help-block">
	                                    <strong>{{ $errors->first('seller_name') }}</strong>
	                                </span>
	                                @endif
	                            </div>
	                        </div>
                            <div class="form-group{{ $errors->has('seller_address') ? ' has-error' : '' }}">
	                            <label class="col-md-4 control-label">Address</label>

	                            <div class="col-md-8">
	                                <input type="text" class="form-control" name="seller_address" value="{{ old('seller_address', $invoice->seller_address) }}" required>

	                                @if ($errors->has('seller_address'))
	                                    <span class="help-block">
	                                    <strong>{{ $errors->first('seller_address') }}</strong>
	                                </span>
	                                @endif
	                            </div>
	                        </div>
                            <div class="form-group{{ $errors->has('seller_state') ? ' has-error' : '' }}">
	                            <label class="col-md-4 control-label">State</label>

	                            <div class="col-md-8">
	                                <input type="text" class="form-control" name="seller_state" value="{{ old('seller_state', $invoice->seller_state) }}" required>

	                                @if ($errors->has('seller_state'))
	                                    <span class="help-block">
	                                    <strong>{{ $errors->first('seller_state') }}</strong>
	                                </span>
	                                @endif
	                            </div>
	                        </div>
                            <div class="form-group{{ $errors->has('seller_country') ? ' has-error' : '' }}">
	                            <label class="col-md-4 control-label">Country</label>

	                            <div class="col-md-8">
	                                <input type="text" class="form-control" name="seller_country" value="{{ old('seller_country', $invoice->seller_country) }}" required>

	                                @if ($errors->has('seller_country'))
	                                    <span class="help-block">
	                                    <strong>{{ $errors->first('seller_country') }}</strong>
	                                </span>
	                                @endif
	                            </div>
	                        </div>
                            <div class="form-group{{ $errors->has('seller_zip') ? ' has-error' : '' }}">
	                            <label class="col-md-4 control-label">Zip</label>

	                            <div class="col-md-8">
	                                <input type="text" class="form-control" name="seller_zip" value="{{ old('seller_zip', $invoice->seller_zip) }}" required>

	                                @if ($errors->has('seller_zip'))
	                                    <span class="help-block">
	                                    <strong>{{ $errors->first('seller_zip') }}</strong>
	                                </span>
	                                @endif
	                            </div>
	                        </div>
                            <div class="form-group{{ $errors->has('seller_taxcode_name') ? ' has-error' : '' }}">
	                            <label class="col-md-4 control-label">Taxcode Name</label>

	                            <div class="col-md-8">
	                                <input type="text" class="form-control" name="seller_taxcode_name" value="{{ old('seller_taxcode_name', $invoice->seller_taxcode_name) }}" >

	                                @if ($errors->has('seller_taxcode_name'))
	                                    <span class="help-block">
	                                    <strong>{{ $errors->first('seller_taxcode_name') }}</strong>
	                                </span>
	                                @endif
	                            </div>
	                        </div>
                            <div class="form-group{{ $errors->has('seller_taxcode_number') ? ' has-error' : '' }}">
	                            <label class="col-md-4 control-label">Taxcode Number</label>

	                            <div class="col-md-8">
	                                <input type="text" class="form-control" name="seller_taxcode_number" value="{{ old('seller_taxcode_number', $invoice->seller_taxcode_number) }}" >

	                                @if ($errors->has('seller_taxcode_number'))
	                                    <span class="help-block">
	                                    <strong>{{ $errors->first('seller_taxcode_number') }}</strong>
	                                </span>
	                                @endif
	                            </div>
	                        </div>
                        </div>
                    </div>
                    
                    <div class="panel panel-info col-md-6 ">
                        <div class="panel-heading">Buyer Info</div>
                        <div class="panel-body">
                            <div class="form-group{{ $errors->has('bill_name') ? ' has-error' : '' }}">
	                            <label class="col-md-4 control-label">Name</label>

	                            <div class="col-md-8">
	                                <input type="text" class="form-control" name="bill_name" value="{{ old('bill_name', $invoice->bill_name) }}" required>

	                                @if ($errors->has('bill_name'))
	                                    <span class="help-block">
	                                    <strong>{{ $errors->first('bill_name') }}</strong>
	                                </span>
	                                @endif
	                            </div>
	                        </div>
                            <div class="form-group{{ $errors->has('bill_address') ? ' has-error' : '' }}">
	                            <label class="col-md-4 control-label">Address</label>

	                            <div class="col-md-8">
	                                <input type="text" class="form-control" name="bill_address" value="{{ old('bill_address', $invoice->bill_address) }}" required>

	                                @if ($errors->has('bill_address'))
	                                    <span class="help-block">
	                                    <strong>{{ $errors->first('bill_address') }}</strong>
	                                </span>
	                                @endif
	                            </div>
	                        </div>
                            <div class="form-group{{ $errors->has('bill_state') ? ' has-error' : '' }}">
	                            <label class="col-md-4 control-label">State</label>

	                            <div class="col-md-8">
	                                <input type="text" class="form-control" name="bill_state" value="{{ old('bill_state', $invoice->bill_state) }}" required>

	                                @if ($errors->has('bill_state'))
	                                    <span class="help-block">
	                                    <strong>{{ $errors->first('bill_state') }}</strong>
	                                </span>
	                                @endif
	                            </div>
	                        </div>
                            <div class="form-group{{ $errors->has('bill_country') ? ' has-error' : '' }}">
	                            <label class="col-md-4 control-label">Country</label>

	                            <div class="col-md-8">
	                                <input type="text" class="form-control" name="bill_country" value="{{ old('bill_country', $invoice->bill_country) }}" required>

	                                @if ($errors->has('bill_country'))
	                                    <span class="help-block">
	                                    <strong>{{ $errors->first('bill_country') }}</strong>
	                                </span>
	                                @endif
	                            </div>
	                        </div>
                            <div class="form-group{{ $errors->has('bill_zip') ? ' has-error' : '' }}">
	                            <label class="col-md-4 control-label">Zip</label>

	                            <div class="col-md-8">
	                                <input type="text" class="form-control" name="bill_zip" value="{{ old('bill_zip', $invoice->bill_zip) }}" required>

	                                @if ($errors->has('bill_zip'))
	                                    <span class="help-block">
	                                    <strong>{{ $errors->first('bill_zip') }}</strong>
	                                </span>
	                                @endif
	                            </div>
	                        </div>
                            <div class="form-group{{ $errors->has('bill_taxcode_name') ? ' has-error' : '' }}">
	                            <label class="col-md-4 control-label">Taxcode Name</label>

	                            <div class="col-md-8">
	                                <input type="text" class="form-control" name="bill_taxcode_name" value="{{ old('bill_taxcode_name', $invoice->bill_taxcode_name) }}" >

	                                @if ($errors->has('bill_taxcode_name'))
	                                    <span class="help-block">
	                                    <strong>{{ $errors->first('bill_taxcode_name') }}</strong>
	                                </span>
	                                @endif
	                            </div>
	                        </div>
                            <div class="form-group{{ $errors->has('bill_taxcode_number') ? ' has-error' : '' }}">
	                            <label class="col-md-4 control-label">Taxcode Number</label>

	                            <div class="col-md-8">
	                                <input type="text" class="form-control" name="bill_taxcode_number" value="{{ old('bill_taxcode_number', $invoice->bill_taxcode_number) }}" >

	                                @if ($errors->has('bill_taxcode_number'))
	                                    <span class="help-block">
	                                    <strong>{{ $errors->first('bill_taxcode_number') }}</strong>
	                                </span>
	                                @endif
	                            </div>
	                        </div>
                        </div> 
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group{{ $errors->has('orders') ? ' has-error' : '' }} ">
                            <label class="col-md-4 control-label"></label>

                            <div class="col-md-8">
                            <input type="hidden" id="amount" name="amount" value="" />
                                <fieldset>
                                <legend>Choose Orders</legend>
                                @foreach($orders as $order)
                                @if(in_array($order->id, $selected_orders))
                                <div>
                                    <input checked type="checkbox" id="order_{{$order->id}}" name="order[]" value="{{$order->id}}">
                                    <label for="order">{{$order->name}}</label>
                                </div>
                                @else
                                <div>
                                    <input type="checkbox" id="order_{{$order->id}}" name="order[]" value="{{$order->id}}">
                                    <label for="order">{{$order->name}}</label>
                                </div>
                                @endif
                                @endforeach
                                </fieldset>
                            </div>
                        </div>  
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <table class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>HSN</th>
                                    <th>Item Name</th>
                                    <th>Cost</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody"> 
                            @foreach($orders as $order)
                                @if(in_array($order->id, $selected_orders))                                
                                <tr id="row_{{$order->id}}">
                                <td><input type="text" class="form-control" name="hsn" id="hsn_{{$order->id}}" value="{{$order->hsn}}" disabled></td>
                                <td><input type="text" class="form-control" name="item_name" id="item_name_{{$order->id}}" value="{{$order->name}}" disabled></td>
                                <td><input type="number" class="form-control" name="cost" id="cost_{{$order->id}}" value="{{$order->cost}}" disabled></td>
                                <td><input type="number" class="form-control" name="qty" id="qty_{{$order->id}}" value="{{$order->qty}}" disabled></td>
                                <td id="line_total_{{$order->id}}">{{$order->cost*$order->qty}}</td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>                            
                        </table>
                        <div class="pull-right">
                            <p id="total"></p>
                        </div>
                    </div>
                    <div class="col-md-6 pull-left">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#terms">Terms</a></li>
                            <li><a data-toggle="tab" href="#footer">Footer</a></li>
                            <li><a data-toggle="tab" href="#notes">Private Notes</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="terms" class="tab-pane fade in active">
                                <textarea class="form-control" rows="5" id="terms" name="terms" >{{ old('terms', $invoice->terms) }}</textarea>
                            </div>
                            <div id="footer" class="tab-pane fade">
                                <textarea class="form-control" rows="5" id="footer" name="footer" >{{ old('footer', $invoice->footer) }}</textarea>
                            </div>
                            <div id="notes" class="tab-pane fade">
                                <textarea class="form-control" rows="5" id="private_notes" name="private_notes" >{{ old('private_notes', $invoice->private_notes) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12 control-label"></label>
                        <div class="col-md-12" align="center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">

var selectedOption;
var total = {{$invoice->amount}};

$("#amount").val(total);

$(function(){
    $("#total").html("Subtotal: Rs. "+{{$invoice->amount}});
});
    
$(function(){

    $(":checkbox").change(function(){
        // To get 'checked' property of checkbox
        var ischecked= $(this).is(':checked');
        // To store selected order value
        selectedOption = $(this).val();
        
        var line_total = 0;      

        if(ischecked)
        {               
            if(selectedOption != '')
            {
                $.post("{{route('admin.invoice.getOrder')}}",{ "_token": "{{ csrf_token() }}" , "id":selectedOption },function (response) {        
                        if (response['status'] === true) {
                            //alert(response['data']);    
                            $("#tableBody").append(
                                '<tr id="row_'+selectedOption+'"><td><input type="text" class="form-control" name="hsn" id="hsn_'+selectedOption+'" disabled></td><td><input type="text" class="form-control" name="item_name" id="item_name_'+selectedOption+'" disabled></td><td><input type="number" class="form-control" name="cost" id="cost_'+selectedOption+'" disabled></td><td><input type="number" class="form-control" name="qty" id="qty_'+selectedOption+'" disabled></td><td id="line_total_'+selectedOption+'"></td></tr>'
                            );
                            $("#hsn_"+selectedOption).val(response['data']['hsn']);
                            $("#item_name_"+selectedOption).val(response['data']['name']);
                            $("#cost_"+selectedOption).val(response['data']['cost']);
                            $("#qty_"+selectedOption).val(response['data']['qty']);
                            line_total = $("#cost_"+selectedOption).val()*$("#qty_"+selectedOption).val();
                            //alert(line_total);
                            $("#line_total_"+selectedOption).html(line_total);

                            total+= line_total; 

                            $("#total").html("Subtotal: Rs. "+total); 

                            $("#amount").val(total);                  
                        }  
                        else {
                            //alert(response['data']);
                        }              
                });
            }
        } 
        else {
            var response = confirm("Are you sure to delete data ?");
            
            //alert(selected);
            if (response == true) {
                
                total -= $("#cost_"+selectedOption).val()*$("#qty_"+selectedOption).val();
                $("#total").html("Subtotal: Rs. "+total);

                $("#row_"+selectedOption).remove();

                $("#amount").val(total);    
            }
            else {
                $("#order_"+selectedOption).prop('checked', true);;
            }
        }       
    });    
});
</script>

@endsection
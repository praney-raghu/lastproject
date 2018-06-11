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
                <div class="panel-heading clearfix">Add a new order                    
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="{{route('admin.order.store')}}">
	                        {!! csrf_field() !!}  
                            <input type="hidden" id="locale" value="{{app()->getLocale()}}" />                  
	                        &nbsp;
	                        <div class="form-group{{ $errors->has('parent_id') ? ' has-error' : '' }}">
	                            <label class="col-md-4 control-label">Parent ID</label>

	                            <div class="col-md-6">
	                                <input type="text" class="form-control" name="parent_id" value="{{ old('parent_id') }}" >

	                                @if ($errors->has('parent_id'))
	                                    <span class="help-block">
	                                    <strong>{{ $errors->first('parent_id') }}</strong>
	                                </span>
	                                @endif
	                            </div>
	                        </div>

	                        <div class="form-group{{ $errors->has('product') ? ' has-error' : '' }}">
	                            <label class="col-md-4 control-label">Product</label>

	                            <div class="col-md-6">
	                
                                    @foreach($products as $product)   
                                        <div class="checkbox-inline">
                                        <input type="checkbox" id="product" name="product[]" value="{{$product->id}}">
                                        <label for="product">{{$product->name}}</label>
                                        </div>
                                    @endforeach
                                    
                                    @if ($errors->has('product'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('product') }}</strong>
                                    </span>
                                    @endif
	                            </div>
	                        </div>
	                        
                            <div class="form-group">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <table class="table table-bordered table-responsive">
                                        <thead>
                                            <tr>
                                                <th>HSN</th>
                                                <th>Name</th>
                                                <th>Cost</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="form-group">
	                            <label class="col-md-4 control-label">Shippable</label>

	                            <div class="col-md-6">
	                                <label class="radio-inline"><input type="radio" name="shippable" checked value="1" required>Yes</label>
	                                <label class="radio-inline"><input type="radio" name="shippable" value="0" required>No</label>
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <label class="col-md-4 control-label">Recurring</label>

	                            <div class="col-md-6">
	                                <label class="radio-inline"><input type="radio" name="recurring" value="1" required>Yes</label>
	                                <label class="radio-inline"><input type="radio" name="recurring" checked value="0" required>No</label>
	                            </div>
	                        </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Save
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

var selected = []; // To store selected Orders IDs
var selectedOption; // To store selected checkbox order value

$(function(){

    $(":checkbox").change(function(){
        // To get 'checked' property of checkbox
        var ischecked= $(this).is(':checked');
        // To store selected order value
        selectedOption = $(this).val();

        var locale = $("#locale").val();
        
        if(ischecked)
        {
            if($.inArray(selectedOption, selected) != -1)
            {
                return false;
            }
            else 
            {
                selected.push(selectedOption);
            }
            
            if(selectedOption != '')
            {
                $.post("{{route('admin.order.getProduct')}}",{ "_token": "{{ csrf_token() }}" , "id":selectedOption },function (response) {        
                        if (response['status'] === true) {
                            //alert(response['data']);    
                            $("#tableBody").append(
                                '<tr id="row_'+selectedOption+'"><td><input type="text" class="form-control" name="hsn[]" id="hsn_'+selectedOption+'" disabled></td><td><input type="text" class="form-control" name="item_name[]" id="item_name_'+selectedOption+'" disabled></td><td><input type="number" class="form-control" name="cost[]" id="cost_'+selectedOption+'" ></td><td><input type="number" class="form-control" name="qty[]" id="qty_'+selectedOption+'" ></td></tr>'
                            );
                            $("#hsn_"+selectedOption).val(response['data']['hsn']);
                            $("#item_name_"+selectedOption).val(response['data']['name'][locale]);
                            $("#cost_"+selectedOption).val(response['data']['cost']);
                            $("#qty_"+selectedOption).val(response['data']['qty']); 

                            $("#selected_orders").val(selected);                  
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
                //alert(selectedOption);
                selected.splice( $.inArray(selectedOption, selected) ,1 );

                $("#row_"+selectedOption).remove();

                $("#selected_orders").val(selected);    
            }
        }       
    });    
});
</script>

@endsection

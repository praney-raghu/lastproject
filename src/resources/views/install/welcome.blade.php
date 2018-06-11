@extends('neev::install.template')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="jumbotron">
                <h2>Neev Setup</h2>
                @if (version_compare(phpversion(), '7.0.0', '<'))
                    <div class="alert alert-warning">Warning: The application requires PHP >= 7.0.0</div>
                @endif
                
                If you need help you can email us at <a href="mailto:contact@ssntpl.com" target="_blank">contact@ssntpl.com</a>.
                
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">Database Connection</div>
                <div class="panel-body">                    
                    {!! Form::open(array('route' => array('install.testDBConnection'),'id' => 'dbform', 'class' => 'form-horizontal')) !!}
                    
                    <div class="form-group">
                    {!! Form::label('host', 'DB_HOST', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                        {!! Form::text('host', config('database.connections.mysql.host') ,['class'=>'form-control','id'=>'host']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                    {!! Form::label('db', 'DB_NAME', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">                        
                        {!! Form::text('db', config('database.connections.mysql.database') ,['class'=>'form-control','id'=>'db']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                    {!! Form::label('username', 'DB_USERNAME', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                        {!! Form::text('username', config('database.connections.mysql.username') ,['class'=>'form-control','id'=>'username']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                    {!! Form::label('pwd', 'DB_PASSWORD', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                        {!! Form::password('db_pwd',null,['class'=>'form-control','id'=>'db_pwd']) !!}
                        </div>
                    </div>
                    <div align="center">                 
                    {!! Form::button('Test Connection', ['class' => 'btn btn-info', 'id' => 'testDatabaseConnection']) !!}
                    &nbsp;
                    <span id="dbTestResult"></span>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">Organisation Details</div>
                <div class="panel-body">                    
                    {!! Form::open(array('route' => array('install.finish'),'id' => 'organisationform', 'class' => 'form-horizontal')) !!}
                    
                    <div class="form-group">
                    {!! Form::label('org_name', 'Organisation Name', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                        {!! Form::text('org_name', null ,['class'=>'form-control','id'=>'org_name']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                    {!! Form::label('org_code', 'Organisation Code', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">                        
                        {!! Form::text('org_code', null ,['class'=>'form-control','id'=>'org_code']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                    {!! Form::label('org_domain', 'Organisation Domain', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                        {!! Form::text('org_domain', Request::getHttpHost() ,['class'=>'form-control','id'=>'org_domain']) !!}
                        </div>
                    </div>                   
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">Admin Details</div>
                <div class="panel-body">                    
                    {!! Form::open(array('route' => array('install.finish'),'id' => 'adminform', 'class' => 'form-horizontal')) !!}
                    
                    <div class="form-group">
                    {!! Form::label('admin_name', 'Name', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                        {!! Form::text('admin_name', null ,['class'=>'form-control','id'=>'admin_name']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                    {!! Form::label('admin_email', 'Email', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">                        
                        {!! Form::email('admin_email', null ,['class'=>'form-control','id'=>'admin_email']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                    {!! Form::label('admin_pwd', 'Password', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                        {!! Form::password('admin_pwd', null ,['class'=>'form-control','id'=>'admin_pwd']) !!}
                        </div>
                    </div>                   
                    {!! Form::close() !!}
                </div>
            </div>
            <div align="center">
                <button type="button" class="btn btn-primary" id="saveData">Submit</button>                
            </div>
            <div>
                <span id="saveDataResult"></span>
            </div>
            &nbsp;
        </div>
    </div>
</div>

<script type="text/javascript">
var check = false;
$("#testDatabaseConnection").click(function(){    
        $("#dbTestResult").html("Working....").css('color','black');        

    $.post("{{route('install.testDBConnection')}}",$("#dbform").serialize(),function (response) {        
            if (response['status'] === true) {
                //alert(response['message']);
                $("#dbTestResult").html(response['message']).css('color','green');
                check = true;
            }  
            else {
                //alert(response['message']);
                $("#dbTestResult").html(response['message']).css('color','red');
            }              
    });
});

$("#saveData").click(function(){ 

    if(check === false)
    {   
        alert("Please Test Database Connection. Make sure your connection is successful.");
    }
    else {
        $("#saveDataResult").html("Please wait...").css('color','black');
        var data = $("#dbform").serialize()+"&"+$("#organisationform").serialize()+"&"+$("#adminform").serialize();

        $.post("{{route('install.finish')}}", data)
            .done(function (response) {
                if (response['status'] === true) {
                
                $("#saveDataResult").html(response['message']).css('color','green');
                window.location.href = "{{route('login')}}";
                }  
                else {                    
                    $("#saveDataResult").html(response['message']).css('color','red');
                }
            })
            .fail(function (response) {
                
                // Below commented code can be used to show particular validation errors.
                // var errorList = JSON.parse(response.responseText);
                
                // var errorText = "<ul>";
                // $.each(errorList.errors, function(key, value){
                //     errorText += "<li>"+value+"</li>";
                // });
                // errorText = errorText+"</ul>";
                var errorText = "All Organisation and Admin fields are required and should be in proper format.";  
                $("#saveDataResult").html(errorText).css('color','red');
            });                         
    } 
});
</script>

@endsection
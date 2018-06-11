@extends('neev::user.layout')

@section('content')
@if(session('success'))
<!-- If password successfully show message -->
<div class="row">
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
</div>
@endif
<section class="content-header">
    <h1>
      User Profile
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-1">
            Name
        </div>
        <div class="col-md-3">
            {{$user["name"]}}
        </div>  
        <p>&nbsp;</p>  
    </div>
    <div class="row">
        <div class="col-md-1">
            E-mail
        </div>
        <div class="col-md-3">
            {{$user["email"]}}
        </div>    
        <p>&nbsp;</p> 
    </div>
    <div class="row">
        <div class="col-md-2">
                <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal">Edit</button>
        </div>
    </div>
</section>    
  <!-- Trigger the modal with a button -->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    {{ Form::open(array('route' => 'user.profile', 'method' => 'PATCH')) }}
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Profile</h4>

      </div>
      <div class="modal-body">
        <p>
        {{ Form::label('Name','Name',array('class'=>'control-label')) }}
        {{ Form::text('newName',$user['name'],array('class'=>'form-control')) }}
        </p>
        <p>    
        {{ Form::label('E-mail','E-mail',array('class'=>'control-label')) }}
        {{ Form::email('newEmail',$user['email'],array('class'=>'form-control')) }}
        </p>   
      </div>
      <div class="modal-footer">
        {{ Form::submit(trans('neev::global.app_save'), ['class' => 'btn btn-danger']) }}  
        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
      </div>
    </div>
    {{ Form::close() }}
  </div>
</div>  
@stop
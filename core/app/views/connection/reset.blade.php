@extends('connection.index')
@section('title')
	{{ trans('auth.resetPageTitle') }}
@stop
@section('content')
    <div class="col-sm-offset-4 col-sm-4">
		<br>
		@if(Session::has('error'))
			<div class="alert alert-danger">{{ Session::get('error') }}</div>
		@endif
		<div class="panel panel-primary">	
			<div class="panel-heading">@lang('reminders.reset_pswd.reset_txt')</div>
			<div class="panel-body"> 
				<div class="col-sm-12">
					{{ Form::open(array('action' => 'AuthController@postReset', 'method' => 'post', 'class' => 'form-horizontal panel')) }}	
					  {{ Form::hidden('token', $token) }}
					  <div class="form-group"><br>
					  	{{ Form::email('email', null, array('class' => 'form-control', 'placeholder' => Lang::get('reminders.reset_pswd.email_ph'))) }}
					  </div>
					  <div class="form-group"><br>
					  	{{ Form::password('password', array('class' => 'form-control', 'placeholder' =>  Lang::get('reminders.reset_pswd.password_ph'))) }}
					  </div>
					  <div class="form-group"><br>
					  	{{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' =>  Lang::get('reminders.reset_pswd.password_conf_ph'))) }}
					  </div> <br>
					  {{ Form::submit( Lang::get('reminders.reset_pswd.send_btn'), array('class' => 'btn btn-primary')) }}
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop
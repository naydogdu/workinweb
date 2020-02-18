@extends('connection.index')
@section('title')
	{{ trans('auth.loginPageTitle') }}
@stop
@section('content')
    <div class="wrap clear tac">
		@if(Session::has('error'))
			<div class="dis-b wrap min pd24 alert bg-ko">{{ Session::get('error') }}</div>
		@endif
		@if(Session::has('status'))
			<div class="dis-b wrap min pd24 alert bg-ok">{{ Session::get('status') }}</div>
		@endif
		{{ Form::open(array('action' => 'AuthController@postLogin', 'method' => 'post', 'class' => 'wrap min min pd96-0 pdt24')) }}	
			@if( $errors->first('email') )
				<div class="bg-ko mrg12-0 pd8">{{ $errors->first('email') }}</div>
			@endif
			<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
				{{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => trans('auth.email') )) }}
			</div>
			@if(Session::has('pass'))
				<div class="bg-ko mrg12-0 pd8">{{ Session::get('pass') }}</div>
			@endif
			<div class="form-group {{ Session::has('pass') ? 'has-error' : '' }}">
				{{ Form::password('password', array('class' => 'form-control', 'placeholder' => trans('auth.password') )) }}
			</div>
			<div class="clear">
				<div class="checkbox floatl pd8-0">
					{{ Form::checkbox( 'souvenir', 1, null, array( 'id' => 'remember' )) }} 
					{{ Form::label( 'remember', trans('auth.remember') ) }}
				</div>
				<div class="floatr">
					{{ Form::submit( trans('auth.login'), array('class' => 'btn wide white mb0' )) }}
				</div>
			</div>
		{{ Form::close() }}
	</div>
@stop
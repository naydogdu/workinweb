@extends('connection.index')
@section('title')
	{{ trans('auth.registerPageTitle') }}
@stop
@section('content')
    <div class="wrap clear tac">
		<div class="panel-heading">
			{{ trans('auth.registerPageTitle') }}
		</div>
		<div class="panel-body"> 
			{{ Form::open(array('url' => '?connection', 'method' => 'post', 'class' => 'wrap min min clear pd96-0 pdt0')) }}	
				@if( $errors->first('email') )
					<div class="bg-ko mrg12-0 pd8">{{ $errors->first('email') }}</div>
				@endif					  
				<div class="form-group {{ $errors->has('email') ? 'has-error has-feedback' : '' }}">
					{{ Form::email('email', null, array('class' => 'form-control', 'placeholder' => trans('auth.email'))) }}
				</div>
				@if( $errors->first('password') )
					<div class="bg-ko mrg12-0 pd8">{{ $errors->first('password') }}</div>
				@endif
				<div class="form-group {{ $errors->has('password') ? 'has-error has-feedback' : '' }}">
					{{ Form::password('password', array('class' => 'form-control', 'placeholder' => trans('auth.password'))) }}
				</div>					  
				<div class="floatr">
					{{ Form::submit( trans('auth.registerLink'), array('class' => 'btn wide white')) }}
				</div>
			{{ Form::close() }}
		</div>
	</div>
@stop
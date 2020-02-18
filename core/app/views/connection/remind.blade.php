@extends('connection.index')
@section('title')
	{{ trans('auth.remindPageTitle') }}
@stop
@section('content')
	@if(Session::has('status'))
		<div class="dis-ib pd24 alert bg-ok">{{ Session::get('status') }}</div>
	@else
		<div class="wrap clear tac">
			<div class="panel-heading">
				{{ trans('auth.remindPageTitle') }}
			</div>
			<div class="panel-body"> 
				{{ Form::open(array('action' => 'AuthController@postRemind', 'method' => 'post', 'class' => 'wrap min min clear pd96-0 pdt0')) }}	
					@if( Session::has('error') )
						<div class="bg-ko mrg12-0 pd8">{{ Session::get('error') }}</div>
					@endif	
					<div class="form-group {{ $errors->has('error') ? 'has-error' : '' }}">
						{{ Form::email('email', null, array('class' => 'form-control', 'placeholder' => trans('auth.email') )) }}
					</div>
					<div class="floatr">
						{{ Form::submit( trans('auth.sendPass'), array('class' => 'btn wide white')) }}
					</div>
				{{ Form::close() }}
			</div>
		</div>
	@endif
@stop
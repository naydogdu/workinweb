@extends('template.index')

@section('content')
    <div id="userCreatePanel">
		<div class="wrap clear">
			<div class="panel panel-primary pd24">	
				<div class="panel-heading">
					<h3>{{ trans('admin.addUser') }}</h3>
				</div>
				<div class="panel-body"> 
					{{ Form::open(array('url' => 'user', 'method' => 'post', 'class' => 'form-horizontal panel')) }}						
						<small class="text-danger">{{ $errors->first('email') }}</small>
						<div class="form-group {{ $errors->has('email') ? 'has-error has-feedback' : '' }}">
							{{ Form::email('email', null, array('class' => 'form-control', 'placeholder' => trans('admin.email') )) }}
						</div>
						<small class="text-danger">{{ $errors->first('password') }}</small>
						<div class="form-group {{ $errors->has('password') ? 'has-error has-feedback' : '' }}">
							{{ Form::password('password', array('class' => 'form-control', 'placeholder' => trans('admin.password') )) }}
						</div>
						<div class="form-group">
							{{ Form::password('Confirmation_mot_de_passe', array('class' => 'form-control', 'placeholder' => trans('admin.confirmPassword') )) }}
						</div>
						{{ Form::submit( trans('admin.submit'), array('class' => 'btn btn-primary')) }}
					{{ Form::close() }}
				</div>
			</div>
			<div class="panel panel-bottom pd24">
				<a href="javascript:history.back()" class="btn btn-primary">
					<span class="glyphicon glyphicon-circle-arrow-left"></span> {{ trans('pagination.backTo') }}
				</a>
			</div>
		</div>		
	</div>
@stop
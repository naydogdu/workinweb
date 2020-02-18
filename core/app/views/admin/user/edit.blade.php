@extends('template.index')

@section('content')
    <div id="editUserPanel">
		<div class="wrap clear">
			@if(Session::has('status'))
				<div class="dis-b pd12-24 col-white alert bg-ok">{{ Session::get('status') }}</div>
			@endif
			<div class="panel panel-primary pd24">	
				<div class="panel-heading">
					<h3>{{ trans('admin.editUser') }}</h3>

				</div>
				<div class="panel-body"> 
					{{ Form::open(array('url' => 'user/' . $user->id, 'method' => 'put', 'class' => 'form-horizontal panel')) }}	
						<small class="text-danger">{{ $errors->first('email') }}</small>
						<div class="form-group {{ $errors->has('email') ? 'has-error has-feedback' : '' }}">
							{{ Form::email('email', $user->email, array('class' => 'form-control', 'placeholder' => trans('admin.email') )) }}
						</div>
						<small class="text-danger">{{ $errors->first('password') }}</small>
						<div class="form-group {{ $errors->has('password') ? 'has-error has-feedback' : '' }}">
							{{ Form::password('password', array('class' => 'form-control', 'placeholder' => trans('admin.newPassword') )) }}
						</div>
						<div class="form-group">
							{{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => trans('admin.confirmPassword') )) }}
						</div>
					   @foreach ($roles as $r)
					   		{{ Form::label($r->id, $r->role)}}
					   		@if($r->id == $user->role_id)
					   		{{ Form::radio('role_id', $r->id, true, array('id' => $r->id)) }}
					   		@else
					   		{{ Form::radio('role_id', $r->id, false, array('id' => $r->id)) }}
					   		@endif
					   @endforeach
					<div class="form-group {{ $errors->has('society') ? 'has-error has-feedback' : '' }}">
						{{ Form::select('society', array('null' => 'aucune', trans('admin.society') => $society), $user->society_id ) }}
					</div>
					<div class="form-group">
					{{ Form::submit( trans('admin.submit'), array('class' => 'btn btn-primary')) }}
					{{ Form::close() }}
					</div>
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
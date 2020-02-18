@extends('template.index')

@section('content')
    <div id="userCreatePanel">
		<div class="wrap clear">
			<div class="panel panel-primary pd24">	
				<div class="panel-heading">
					<h3>{{ trans('admin.addSociety') }}</h3>
				</div>
				<div class="panel-body"> 
					{{ Form::open(array('url' => 'society-admin', 'method' => 'POST', 'class' => 'form-horizontal panel')) }}						
						<small class="text-danger">{{ $errors->first('nameSociety') }}</small>
						<div class="form-group {{ $errors->has('nameSociety') ? 'has-error has-feedback' : '' }}">
							{{ Form::text('nameSociety', null, array('class' => 'form-control', 'placeholder' => trans('admin.nameSociety') )) }}
						</div>
						<small class="text-danger">{{ $errors->first('siret') }}</small>
						<div class="form-group {{ $errors->has('siret') ? 'has-error has-feedback' : '' }}">
							{{ Form::text('siret', null , array('class' => 'form-control', 'placeholder' => trans('admin.siret') )) }}
						</div>
						<small class="text-danger">{{ $errors->first('creator') }}</small>
						<div class="form-group {{ $errors->has('creator') ? 'has-error has-feedback' : '' }}">
							{{ Form::select('creator', array('null' => trans('admin.none'), trans('admin.users') => $users)) }}
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
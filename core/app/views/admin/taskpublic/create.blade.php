@extends('template.index')

@section('content')
    <div id="userCreatePanel">
		<div class="wrap clear">
			<div class="panel panel-primary pd24">	
				<div class="panel-heading">
					<h3>{{ trans('admin.addTaskPublic') }}</h3>
				</div>
				<div class="panel-body"> 
					{{ Form::open(array('url' => 'taskpublic-admin', 'method' => 'POST', 'class' => 'form-horizontal panel')) }}						
						<small class="text-danger">{{ $errors->first('title') }}</small>
						<div class="form-group {{ $errors->has('title') ? 'has-error has-feedback' : '' }}">
							{{ Form::text('title', null, array('class' => 'form-control', 'placeholder' => trans('admin.titleTask') )) }}
						</div>
						<small class="text-danger">{{ $errors->first('typeProject') }}</small>
						<div class="form-group {{ $errors->has('typeProject') ? 'has-error has-feedback' : '' }}">
							{{ Form::select('typeProject', array(trans('admin.typeProject') => $listTypesProjects), Input::get('type')) }}
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
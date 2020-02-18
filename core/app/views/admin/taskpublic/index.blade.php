@extends('template.index')

@section('title')
	@lang('admin.indexTask')
@stop

@section('content')
	<div id="userGlobalList">
		<div class="wrap clear">
			@if(Session::has('status'))
				<div class="dis-b pd12-24 col-white alert bg-ok">{{ Session::get('status') }}</div>
			@endif

			<div class="panel panel-primary pd24">
				<div class="panel-heading">
					<h3 class="panel-title">{{ trans('admin.indexTask') }}</h3>
					<small class="text-danger">{{ $errors->first('title') }}</small>
				</div>
			</div>

			@foreach($typeProject as $t)
				<div class="panel panel-primary pd24">
					<div class="panel-heading">
						<div class="floatr-800">
						{{ link_to_route('taskpublic-admin.create', trans('admin.addTask'), array('type' => $t->id) ,array('class' => 'btn btn-success btn-block') )}}
						</div>
						<h3 class="panel-title">{{ $t->name }}</h3>
					</div>			  
					<div class="panel-body">
					@foreach($t->tasksPublic as $task)
						<div class="itemlist bb1-grey clear pd12-0 user-id_{{ $task->id }}">
							<div class="floatr-800">
								{{ Form::open(array('method' => 'DELETE', 'route' => array('taskpublic-admin.destroy', $task->id), 'class' => 'dis-ib')) }}
								{{ Form::submit( trans('admin.deleteTask'),array(
									'class' => 'btn btn-danger btn-block mb0', 
									'onclick' => 'return confirm("' . trans('admin.areYouSureDeleteTask') . '")')
								) }}	
								{{ Form::close() }}
								{{ Form::open(array('method' => 'PUT', 'route' => array('taskpublic-admin.update', $task->id), 'class' => 'dis-ib')) }}
								{{ Form::submit( trans('admin.update'),array('class' => 'btn btn-danger btn-block mb0')) }}	
							</div>
								{{ Form::text('title', $task->title, array('class' => 'form-control', 'placeholder' => trans('admin.titleTask') )) }}
								{{ Form::close() }}
						</div>
					@endforeach
					</div>
				</div>
			@endforeach

			<div class="panel panel-bottom pd24">
				{{-- link_to_route('user.create', trans('admin.addUser'), null, array('class' => 'btn btn-primary')) --}}
			</div>
		</div>
	</div>
@stop
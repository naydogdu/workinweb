@extends('template.index')

@section('title')
	@lang('task.createTask')
@stop

@section('content')
	{{ Form::open(array('route' => array('task.store', 'id' => $profil->project->id), 'method' => 'post', 'class' => 'form-horizontal'))}}
		<header class="article-header bg-bluebis mb24">
			<div class="wrap clear pd24-0">
				<h2 class="dis-ib col-white">@lang('task.createTaskTitle')</h2>		
				{{ Form::submit(trans('task.createTaskTitle'), array('class' => 'btn floatr saveAll')) }} 					
				{{ link_to_route('project.show', trans('pagination.backToProject'), $profil->project->generated_url , array('class' => 'btn floatr')) }}
			</div>
		</header>
		<div class="wrap clear">
			@if(Session::has('status'))
				<div class="dis-b pd12-24 col-white alert bg-ok floatl-800 w65-800">
					{{ Session::get('status') }}
				</div>
			@endif
			@if(Session::has('error'))
				<div class="dis-b pd12-24 col-white alert bg-ko floatl-800 w65-800">{{ Session::get('error') }}</div>
			@endif	
			<div class="floatr-800 w35-800 pdl24-800 mb24">
				<div class="panel panel-primary pd24 pdb0">
					<div class="panel-heading">
						<h3>{{trans('task.addTaskUser')}}</h3>
						<span class="dis-b"><small>{{trans('task.addTaskLegend')}}</small></span>
					</div>					
					<div class="clear panel-body">
						<small class="text-danger">{{ $errors->first('participant') }}</small>
						@foreach ($profil as $a)						
							<div class="itemlist bb1-grey pd12-0">
								{{ Form::checkbox('participant[]', $a->user['id'], false,  array('id' => $a->user['email'], 'class' => 'picto floatl posabs') )}}
								<label class="posrel z9" for="{{ $a->user['email'] }}">
									{{ helpers::getAvatar($a->user['id'], 'floatl round hw40 divbg dis-ib') }}
								</label>
								<h5 class="dis-ib username pd12 pdl6">
									@if(helpers::checkPublicName($a->user['id']))
										{{ helpers::checkPublicName($a->user['id']) }}
									@else
										{{ $a->user['email'] }}
									@endif
								</h5>
							</div>
						@endforeach
					</div>
				</div>
			</div>
			<div class="panel panel-primary pd24 mb24 floatl-800 w65-800">
				<div class="panel-heading">					
					<h3>@lang('project.editHeadingGlobal')</h3>
				</div>
				<div class="panel-body">				
					<small class="text-danger">{{ $errors->first('title') }}</small>
					<div class="form-group {{ $errors->has('title') ? 'has-error has-feedback' : '' }}">
						{{ Form::label('title', trans('public.title')) }}
						{{ Form::text('title', null , array('class' => 'form-control', 'placeholder' => trans('public.title') )) }}
					</div>
					<div class="form-group">
						{{ Form::label('noDate', trans('project.noDate')) }}
						{{ Form::checkbox('noDate', 'check' ,false) }}
					</div>
					@if (helpers::checkEndDateProject($profil->project->id))
						<small class="text-danger">{{ Session::get('date') }}</small>
						<div class="form-group">
							{{ Form::label('dayBegin', trans('task.dateBegin')) }}					
							{{ Form::selectRange('dayBegin', 1, 31,   substr($profil->project->begin_date, 8,2))}}
							{{ Form::selectMonth('monthBegin', substr($profil->project->begin_date, 5,2)) }}
							{{ Form::selectRange('yearBegin', date('Y'), date('Y')+5, substr($profil->project->begin_date, 0,4)) }}
						</div>	
						<small class="text-danger">{{ $errors->first('dateEnd') }}</small>
						<div class="form-group">
							{{ Form::label('dayEnd', trans('task.dateEnd')) }}						
							{{ Form::selectRange('dayEnd', 1, 31, substr($profil->project->end_date, 8,2))}}
							{{ Form::selectMonth('monthEnd', substr($profil->project->end_date, 5,2)) }}
							{{ Form::selectRange('yearEnd', date('Y'), date('Y')+5, substr($profil->project->end_date, 0,4)) }}
						</div>
					@else
						<small class="text-danger">{{ Session::get('date') }}</small>
						<div class="form-group">
							{{ Form::label('dayBegin_2', trans('task.dateBegin')) }}					
							{{ Form::selectRange('dayBegin_2', 1, 31,   substr($profil->project->begin_date, 8,2))}}
							{{ Form::selectMonth('monthBegin', substr($profil->project->begin_date, 5,2)) }}
							{{ Form::selectRange('yearBegin', date('Y'), date('Y')+5, substr($profil->project->begin_date, 0,4)) }}
						</div>	
						<small class="text-danger">{{ $errors->first('dateEnd') }}</small>
						<div class="form-group">
							{{ Form::label('dayEnd', trans('task.dateEnd')) }}						
							{{ Form::selectRange('dayEnd', 1, 31, substr($profil->project->begin_date, 8,2)+1)}}
							{{ Form::selectMonth('monthEnd', substr($profil->project->begin_date, 5,2)) }}
							{{ Form::selectRange('yearEnd', date('Y'), date('Y')+5, substr($profil->project->begin_date, 0,4)) }}
						</div>
					@endif
				</div>
				{{ Form::close()}}
			</div>
			<div class="panel panel-primary pd24 mb24 floatl-800 w65-800">
				<div class="panel-heading">
					{{ Form::open(array('route' => array('addPublicTask', 'id' => $profil->project->id), 'title' => trans('project.add') ,'method' => 'PUT', 'class' => 'form-horizontal')) }}
					{{ Form::submit(trans('project.add'), array('class' => 'btn floatr saveAll')) }}	
					<h3 class="dis-ib">@lang('project.tasksPublic')</h3>
				</div>
				@foreach ($profil->tasksGlobale as $task)
						<div class="panel-body">				
							<div class="form-group {{ $errors->has('title') ? 'has-error has-feedback' : '' }}">
								{{ Form::text('title', $task->title , array( 'disabled'=> 'disabled', 'class' => 'form-control', 'placeholder' => trans('public.title') )) }}
								{{ Form::label($task->id, trans('project.add')) }}
								{{ Form::checkbox('addTask[]', $task->id ,false, array('id' => $task->id)) }}
							</div>
						</div>
				@endforeach
			</div>

			{{ Form::close()}}
		</div>

@stop
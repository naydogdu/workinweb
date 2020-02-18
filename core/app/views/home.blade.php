@extends('template.index')

@section('title')
	{{ 'Home Page' }}
@stop

@section('content')
	<div id="editUserPanel">
		<div class="wrap clear">
			
			<div class="panel panel-primary w70-600 floatl-600">	
				<div class="pd24 bb1-grey">
					<h3 class="dis-ib">{{ trans('public.projectsInProgress') }}</h3>
					<a href="{{ URL::route('project.create') }}" class="floatr dis-ib"><i class="fa fa-plus pdr6"></i> {{ trans('public.addProject') }}</a>
				</div>
				<div class="panel">
					@foreach ($projects as $project)
						<div class="item bb1-grey pd12-24 clear">
							<div class="floatl w65">	
								<p><a href='{{ url("project")."/".$project->generated_url }}'> {{ $project->name }} </a></p>
								<small>{{ $project->description }}</small>
							</div>
							<div class="floatr w30 pd4-0">
								<div class="progress-area pd12">			
									<div class="progress-bg bg-whitebis">
										<span class="dis-b progress-rate bg-ok" style="width: {{ $project->timePourcentage }}%;"></span>
									</div>				
								</div>
							</div>
						</div>
					@endforeach
				</div>					
			</div>	

			<div class="pdl24-600 w30-600 floatr-600">	
				<div class="panel panel-primary">
					<div class="pd24 bb1-grey">
						<h3>{{ trans('public.tasksInProgress') }}</h3>
					</div>
					<div class="panel">							
						@foreach ($tasks as $task)
							@if( !empty( helpers::getTaskProject($task->pivot->user_id, $task->pivot->task_id) ) )
								<div class="item bb1-grey pd12-24 clear">
									<p><a href='{{ url("project")."/".helpers::getUrlProject($task->pivot->user_id, $task->pivot->task_id) }}'> {{$task->title}} </a></p>
									{{ helpers::getTaskProject($task->pivot->user_id, $task->pivot->task_id) }}	
								</div>
							@endif
						@endforeach
					</div>

					<!--<div class="panel-body">
					<h4>Tâche abandonnées : </h4>
						@foreach ($tasksTrashed as $task)
							<p>Titre :<a href='{{ url("project")."/".helpers::getUrlProject($task->pivot->user_id, $task->pivot->task_id) }}'> {{$task->title}} </a></p>
						@endforeach
					</div>-->
				</div>
			</div>
		</div>
	</div>
@stop
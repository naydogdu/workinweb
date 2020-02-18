@extends('template.index')

{{-- 
	Variables accessibles :
	$profils Array
	$profil Object
		=> $profil->id
		=> $profil->first_name
		=> $profil->last_name
		=> $profil->gender
		=> $profil->birthday
		=> $profil->occupation
		=> $profil->user_id
--}}

@section('content')
    <div id="editprofilPanel">
		<div class="wrap clear">
			<div class="floatl-600 w25-600">		
				<div class="panel panel-primary mb24 pd24 ">		
					<div class="mb12">{{ helpers::getAvatar($profil->user_id) }}</div>
					<h3>{{ $profil->first_name }} {{ $profil->last_name }}</h3>
					<p class="op0-6">{{ $profil->occupation }}, {{ round( (time() - strtotime($profil->birthday)) / 3600 / 24 / 365 ) }} {{ trans('profil.yearsOld') }}</p>
				</div>				

				<div class="panel panel-primary">						
					<div class="pd24 bb1-grey">
						<h3>{{ trans('public.tasksInProgress') }}</h3>
					</div>
					@foreach ($tasks as $task)
						<div class="item bb1-grey pd12-24 clear">
							<p><a href='{{ url("project")."/".helpers::getUrlProject($task->pivot->user_id, $task->pivot->task_id) }}'> {{$task->title}} </a></p>
							{{ helpers::getTaskProject($task->pivot->user_id, $task->pivot->task_id) }}	
						</div>
					@endforeach
				</div>
			</div>
			<div class="pdl24-600 floatl-600 w75-600">	
				<div class="panel panel-primary pd24 bb1-grey">
					<h3>{{ trans('public.projectsInProgress') }}</h3>
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
		</div>
	</div>
@stop
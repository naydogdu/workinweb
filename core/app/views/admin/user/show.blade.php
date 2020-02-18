@extends('template.index')

{{-- 
	Variables accessibles :
	$profil array
		=> first_name
		=> last_name
		=> gender
		=> occupation
		=> birthday
		=> user_id
		=> avatar_id
		$role object
			=> role['role']
		$profil object
			=> email
			=> id
			=> created_at
			=> updated_at
			=> roles_meta_id
			=> password
			=> remember_token
--}}

@section('content')
	<div id="editUserPanel">
		<div class="wrap clear">
			<div class="panel panel-primary pd24">	
				<div class="panel-heading">
					<h3>{{ trans('admin.profil') }}</h3>
				</div>
				<div class="panel-body"> 
					<p>{{ trans('admin.email') }} : {{ $profil->user->email }}</p>
					<p>{{ trans('admin.role') }} : {{ helpers::getRole($profil->user->email) }}</p>
					<p>{{ trans('admin.firstName') }} : {{ $profil->first_name }}</p>
					<p>{{ trans('admin.lastName')}} : {{ $profil->last_name }}</p>
					<p>{{ trans('admin.gender')}} : {{  $profil->gender }}</p>
					<p>{{ trans('admin.occupation')}} : {{ $profil->occupation }}</p>
					<p>{{ trans('admin.birthday')}} : {{ $profil->birthday }}</p>
					<p>{{ trans('admin.society')}} : {{ helpers::getSocietyName($profil->user->society_id) }}</p>
					<P>{{ trans('profil.avatar')}} : {{ helpers::getAvatar($profil->user_id) }}
				</div>

			</div>	
			<div class="panel panel-bottom pd24">
				<a href="javascript:history.back()" class="btn btn-primary">
					<span class="glyphicon glyphicon-circle-arrow-left"></span> {{ trans('pagination.backTo') }}
				</a>
			</div>
		</div>
		<div class="wrap clear">
			<div class="panel panel-primary pd24">	
				<div class="panel-heading">
					<h3>{{ trans('admin.projects') }}</h3>
				</div>
				<div class="panel-body"> 
					@if (count(helpers::getProjectsUser($profil->user_id)) == 0 )
						<p>{{ trans('admin.noProject') }}</p>
					@else
						@foreach (helpers::getProjectsUser($profil->user_id) as $project)
							<p>{{ link_to_route('project.show', $project->name, array($project->generated_url)) }}</p>
						@endforeach
					@endif
				</div>
			</div>
		</div>
		<div class="wrap clear">
			<div class="panel panel-primary pd24">	
				<div class="panel-heading">
					<h3>{{ trans('admin.tasks') }}</h3>
				</div>
				<div class="panel-body"> 		
						@foreach (helpers::getTasksUserWithoutTrash($profil->user_id) as $task)
							<p>{{ link_to_route('project.show', $task->title, array(helpers::getUrlProject($task->pivot->user_id, $task->pivot->task_id)) ) }}</p>
						@endforeach
				</div>
			</div>
		</div>
		<?php 
		// foreach (helpers::getProjectsUser($profil->user_id) as $projet) {
		// 	var_dump($projet);
		// }
		 ?>
	</div>
@stop
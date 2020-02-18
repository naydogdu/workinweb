@extends('template.index')

@section('title')
	{{ $project->name }}
@stop

@section('content')

	<header class="article-header bg-bluebis mb24">
		<div class="wrap clear pd24-0 col-white">
			<div class="dis-ib">
				<h2>{{ $project->name }}</h2>
				<span class="dis-b"><i id="opn-toggle-1" class="fa fa-info-circle opn-toggle"></i>  {{ $project->typeProject->name }}</span>
			</div>
			<div class="progress-area dis-ib w20 pd0-24">
				<span class="percentage-value">
					{{ $project->timePourcentage }} % 
					@if (isset($project->deleted_at))
						<i>- {{trans('public.cancelled')}}</i>
					@endif
				</span>
				<div class="progress-bg bg-rgba0-1">
					<span class="dis-b progress-rate bg-white" style="width: {{ $project->timePourcentage }}%;"></span>
				</div>
			</div>
			@if(Auth::user()->role_id === 1 || helpers::getPermission(Auth::id(), $project->generated_url) == 1)
				<div class="w30 floatr pd8-0 tar">
					{{ Form::open(array('method' => 'DELETE', 'route' => array('project.destroy', $project->id), 'class' => 'dis-ib')) }}
						{{ Form::submit( trans('public.delete'), 
							array(
							'class' => 'btn btn-danger btn-block mb0', 
							'onclick' => 'return confirm("' . trans('public.areYouSureDeleteProjectDefin') . '")'
							) 
						) }}
					{{ Form::close() }}				
					{{ link_to_route('project.edit', trans('public.edit'), $project->generated_url, array('class' => 'btn btn-primary saveAll')) }}				
					@if (isset($project->deleted_at))
						{{ Form::open(array('method' => 'PUT', 'route' => array('restoreProject', $project->id), 'class' => 'dis-ib')) }}
						{{ Form::submit( trans('public.restore'), array('class' => 'btn btn-block mb0')) }}
						{{ Form::close() }}
					@endif
				</div>
			@endif
		</div>
	</header>
	<div id="opn-this-1" class="opn-this bg-white mb24">
		<div class="wrap clear pd24-0">{{ $project->description }}</div>
	</div>
	<div class="wrap clear pd24-0">		
		<div class="floatr-800 w40-800 pdl24-800">
			<div class="panel panel-primary pd24 pdb0 mb24">	
				<div class="panel-heading">
					<h3 class="dis-ib">@lang('project.participant')</h3>
					@if (Auth::user()->role_id === 1 || helpers::getPermission(Auth::id(), $project->generated_url) == 1)
						<a class="floatr btn wide dis-in" href="{{ URL::route('project.edit', array('id' => $project->generated_url)) }}" title="{{ trans('project.edit') }}"><i class="fa fa-pencil"></i></a>
					@endif	
				</div>				
				<div class="panel-body"> 
					@foreach ($project->users as $a)
						<div class="itemlist bb1-grey pd24-0">
							<div class="clear">
								<a class="floatl pd0-24 pdl0" href="{{ URL::route('profil.show', $a->pivot->user_id)}}">
									{{ helpers::getAvatar($a->pivot->user_id, 'round hw80 divbg') }}
								</a>	
								<div class="floatl">
									<p class="bigsize">{{ helpers::checkPublicName($a->pivot->user_id) }}</p>											
									<p class="small">{{ $a->pivot->permission_name}}</p>
									<p><a class="btn mini" href="{{ URL::route('profil.show', $a->pivot->user_id)}}">{{ trans('profil.view') }}</a></p>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
			<div class="panel panel-primary pd24 pdb0 mb24">	
				<div class="panel-heading">
					<h3>{{ trans('project.statistics') }}</h3>
				</div>
				<div class="panel pd24-0">
				@if(helpers::checkEndDateProject($project->id))
					<p>{{ trans('public.dateBegin') }} : {{ date('d/m/Y', strtotime($project->begin_date) ) }}</p>
					<p>{{ trans('public.dateEnd') }} : <strong>{{ date('d/m/Y', strtotime($project->end_date) ) }}</strong></p>

				@else 
					<p>{{ trans('project.createProject') }} : {{ date('d/m/Y', strtotime($project->begin_date)) }} / {{ trans('public.dateEnd') }} : {{ trans('project.unknown') }} </p>
				@endif
				</div>
			</div>
		</div>
		<div class="panel panel-primary mb24 floatl-800 w60-800">	
			<div class="pd24 bb1-grey">				
				<h3 class="dis-ib">@lang('project.tasks')</h3>
				@if (Auth::user()->role_id === 1 || helpers::getPermission(Auth::id(), $project->generated_url) == 1)
					<a class="floatr btn wide dis-in" href="{{ URL::route('task.create', array('id' => $project->id)) }}" title="{{ trans('project.addTask') }}"><i class="fa fa-plus pdr6"></i> {{ trans('project.addTask') }}</a>
				@endif				
			</div>
			<?php $rep = false; ?>
			@if(isset($project->tasks[0]))
				@foreach( $project->tasks as $task )				
					@if ($task->deleted_at == null)
						<div class="panel-body clear">						
							<div class="itemlist pd12-24 {{ helpers::getStatusTask($task->pivot->status_id) }}"> 
								<div class="clear">
									<div id="opn-toggle-99{{ $task->id }}" class="floatl pd0-12 pdl0 opn-toggle">
										<i class="fa fa-user"></i>
									</div>								
									<div id="opn-toggle-88{{ $task->id }}" class="floatl pd0-12 pdl0 opn-toggle">
										<p>{{ $task->title }}</p>
									</div>
									<p class="floatr">{{ helpers::getStatusTask($task->pivot->status_id, true) }}</p>
									<p class="floatr pd0-12 pdl0">
										@if( count($task->tickets) > 0 )
											<a title="{{ trans('public.viewDiscussion') }}" href="{{ URL::route('task.tickets.index', $task->id)}}">
												<span class="view-ticket dis-n dis-ib-1200 op0 pdr6">@if( count($task->tickets) > 1 ) {{ trans('public.viewDiscussion') }} @else {{ trans('public.viewSingleTicket') }} @endif</span>
												<span class="bold">{{ count($task->tickets) }}</span>
												<i class="fa fa-comments-o"></i>
											</a>
										@else
											<a title="{{ trans('public.postTicket') }}" class="op0-3" href="{{ URL::route('task.tickets.index', $task->id)}}">
												<span class="view-ticket dis-n dis-ib-1200 pdr6">{{ trans('public.postTicket') }}</span>
												<i class="fa fa-comments-o"></i>
											</a>
										@endif									
									</p>
								</div>
								@if (helpers::getNumberPeopleTask($task->id) != 0)
								<div id="opn-this-99{{ $task->id }}" class="clear mrg12-0 mb0 opn-this">
									@foreach ($task->users as $user)
										<a class="floatl pd0-24 pdl0" href="{{ URL::route('profil.show', $a->pivot->user_id)}}">
											{{ helpers::getAvatar($user->id) }} <span class="dis-ib pd8-0">{{ helpers::checkPublicName($user->id) }}</span>
										</a>
									@endforeach
								</div>
								@endif
								<div id="opn-this-88{{ $task->id }}" class="clear posrel mrg12-0 mb0 opn-this">
									@if (Auth::user()->role_id === 1 || helpers::getPermission(Auth::id(), $project->generated_url) == 1)
										<a class="floatr pd0-12 pdr0" href="{{ URL::route('task.edit', array($task->pivot->task_id, 'id' => $project->id)) }}" title="{{ trans('public.edit') }}"><i class="fa fa-pencil"></i></a>
									@endif
									@if (helpers::checkEndDateTask($task->id))
									<p>{{ trans('project.beggining') }} {{ $task->pivot->begin_date }} / {{ trans('project.end') }} {{ $task->pivot->end_date }}</p>
									<p>{{ trans('project.nbPeopleTask') }} : {{ helpers::getNumberPeopleTask($task->id) }}</p>
									@else
									<p>{{ trans('project.createTask') }} : {{ $task->pivot->begin_date }}</p>
									<p>{{ trans('project.nbPeopleTask') }} : {{ helpers::getNumberPeopleTask($task->id) }}</p>
									@endif
									@if (Auth::user()->role_id === 1 || helpers::getPermission(Auth::id(), $project->generated_url) == 1)
										{{ Form::open(array('method' => 'DELETE', 'route' => array('task.destroy', $task->pivot->task_id, 'id' => $project->id), 'class' => 'posabs mrg12-0 mb0 r0')) }}
											{{ Form::submit( trans('public.delete'), array( 'class' => 'btn mini bg-ko')) }}
										{{ Form::close() }}
									@endif
								</div>
							</div>	
						</div>						
					@else
						<?php $rep = true; ?>
					@endif
				@endforeach
			@else
				<div class="panel-body clear">
					<p class="itemlist pd12-24">{{ trans('project.youHaventTask') }}</p>
				</div>
			@endif
		</div>				

		@if($rep == true)
			<div class="panel panel-primary mb24 floatl-800 w60-800">
				<div class="pd24 bb1-grey">
					<h3>@lang('project.trashTasks')</h3>
				</div>				
				@foreach( $project->tasks as $task )
					@if ($task->deleted_at != null)
						<div class="pd12-24 bb1-grey clear">
							<p class="floatl">{{ $task->title }}</p>
							<div class="floatr">
								{{ link_to_route('task.edit', trans('public.edit'), array($task->pivot->task_id, 'id' => $project->id), array('class' => 'btn wide mini')) }}
								{{ Form::open(array('method' => 'DELETE', 'route' => array('task.destroy', $task->pivot->task_id, 'id' => $project->id), 'class' => 'dis-ib')) }}
									{{ Form::submit( trans('public.delete'), array( 'class' => 'btn mini')) }}
								{{ Form::close() }}
								@if (isset($task->deleted_at))
									{{ Form::open(array('method' => 'PUT', 'route' => array('restoreTask', $task->pivot->task_id), 'class' => 'dis-ib')) }}
										{{ Form::submit( trans('public.restore'), array('class' => 'btn mini')) }}
									{{ Form::close() }}
								@endif
							</div>
						</div>
					@endif
				@endforeach
			</div>
		@endif	
	</div>
@stop
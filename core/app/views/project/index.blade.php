@extends('template.index')

@section('title')
	@lang('project.project')
@stop

@section('content')
	<header class="article-header bg-bluebis mb24">
		<div class="wrap clear pd24-0">
			<h2 class="dis-ib col-white">@lang('nav.projectLink')</h2>
			{{ link_to_route('project.create', trans('public.addProject'), null, array('class' => 'btn btn-primary saveAll floatr')) }}
		</div>
	</header>
	<div class="wrap clear panel mb24">
		@foreach($projects as $project)
			<div class="item bb1-grey pd12-24 clear">
				<ul class="w45 floatl pd8-0">
					<li>{{ HTML::linkRoute('projectShow', $project->name, $project->generated_url) }}</li>
					<li><small>{{ $project->description }}</small></li>
				</ul>
				<div class="progress-area floatl w25 pd24">			
					<div class="progress-bg bg-whitebis">
						<span class="dis-b progress-rate bg-ok" style="width: {{ $project->timePourcentage }}%;"></span>
					</div>				
				</div>
				<div class="floatl w15 tac pd12-0">
					<div class="pd8">{{ $project->timePourcentage }} % </div>
				</div>
				<div class="floatr w15 tar pd12-0">
					<div class="pd8">{{ $project->tasksStatus }}</div>
				</div>
			</div>
		@endforeach
	</div>
	
	@if (isset($trashProjects[0]))
		<div class="wrap clear panel mb24">
			<div class="item bb1-grey pd24 clear">
				<h4 class="op0-7">{{ trans('project.trash')}} </h4>
			</div>
			@foreach($trashProjects as $project)
				<div class="item bb1-grey pd12-24 clear">
					<ul class="op0-7 w50 floatl pd8-0">
						<li>{{ HTML::linkRoute('projectShow', $project->name, $project->generated_url) }}</li>
						<li><small>{{ $project->description }}</small></li>
					</ul>
					<div class="floatr w50 tar pd12-0">
						@if (isset($project->deleted_at))
							{{ Form::open(array('method' => 'PUT', 'route' => array('restoreProject', $project->id), 'class' => 'dis-ib')) }}
								{{ Form::submit( trans('public.restore'), array('class' => 'btn btn-block mb0')) }}
							{{ Form::close() }}
						@endif
						{{ Form::open(array('method' => 'DELETE', 'route' => array('project.destroy', $project->id), 'class' => 'dis-ib')) }}
							{{ Form::submit( trans('public.deleteDefin'), 
								array(
								'class' => 'btn btn-danger btn-block mb0', 
								'onclick' => 'return confirm("' . trans('public.areYouSureDeleteProjectDefin') . '")'
								) 
							) }}
						{{ Form::close() }}		
					</div>
				</div>				
			@endforeach
		</div>
	@endif

@stop
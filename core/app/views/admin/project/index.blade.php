@extends('template.index')

@section('content')
	<div id="userGlobalList">
		<div class="wrap clear">
			@if(Session::has('status'))
				<div class="dis-b pd12-24 col-white alert bg-ok">{{ Session::get('status') }}</div>
			@endif
			<div class="panel panel-primary pd24">
				<div class="panel-heading">
					<h3 class="panel-title">{{ trans('admin.projectsList') }}</h3>
				</div>
			</div>

			@foreach ($societys as $society)
			<div class="panel panel-primary pd24">
				<div class="panel-heading">
					<h4 class="panel-title">{{ $society->name }}</h4>
				</div>			  
				<div class="panel-body">
				@foreach ($society->projects as $project)
					<div class="itemlist bb1-grey clear pd12-0">
						<span class="dis-ib pd8-0"><a class="floatl pd0-24 pdl0" href="{{ URL::route('project.show', $project->generated_url)}}">{{ $project->name }}</a>
						{{ trans('admin.type') }} : {{ helpers::getTypeProject($project->type_project_id) }} --
						{{ trans('admin.peopleNb') }} : {{ helpers::getNumberPeopleProject($project->id) }} --
						{{ trans('admin.taskNb') }} : {{ helpers::getNumberTaskProject($project->id) }}
						</span>
						<div class="floatr-800">
							{{ link_to_route('project.show', trans('admin.see'), $project->generated_url, array('class' => 'btn btn-success btn-block')) }}
							{{ link_to_route('project.edit', trans('admin.editProject'), $project->generated_url, array('class' => 'btn btn-success btn-block')) }}
							{{ Form::open(array('method' => 'DELETE', 'route' => array('project.destroy', $project->id), 'class' => 'dis-ib')) }}
							{{ Form::submit( trans('public.delete'), 
								array(
								'class' => 'btn btn-danger btn-block mb0', 
								'onclick' => 'return confirm("' . trans('public.areYouSureDeleteProject') . '")'
								) 
							) }}
							{{ Form::close() }}	
						</div>
					</div>
				@endforeach
				</div>
			</div>
			@endforeach
		</div>
	</div>
@stop
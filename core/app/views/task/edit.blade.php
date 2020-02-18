@extends('template.index')

@section('title')
	@lang('task.editTask')
@stop

@section('content')
	{{ Form::open(array('route' => array('task.update', $profil->task->id, 'id' => $profil->project->id), 'method' => 'PUT', 'class' => 'form-horizontal'))}}
		<header class="article-header bg-bluebis mb24">
			<div class="wrap clear pd24-0">
				<h2 class="dis-ib col-white">@lang('task.editTaskTitle')</h2>
				{{ Form::submit(trans('public.saveAll'), array('class' => 'btn floatr saveAll')) }}
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
							<?php $rep = false; ?>
							<div class="itemlist bb1-grey pd12-0">
								@foreach ($profil->task->users as $user)
									@if($user->email == $a->email)
										<?php $rep = true; ?>
									@endif
								@endforeach
								{{ Form::checkbox('participant[]', $a->user_id, $rep,  array('id' => $a->email, 'class' => 'picto floatl posabs') )}}
								<label class="posrel z9" for="{{ $a->email }}">
									{{ helpers::getAvatar($a->id, 'floatl round hw40 divbg dis-ib') }}
								</label>
								<h5 class="dis-ib username pd12-0 pdl6">
									@if(helpers::checkPublicName($a->id))
										{{ helpers::checkPublicName($a->id) }}
									@else
										{{ $a->email }}
									@endif
								</h5>
							</div>
						@endforeach
					</div>
				</div>
			</div>
			<div class="panel panel-primary floatl-800 w65-800 pd24 mb24">
				<div class="panel-heading">					
					<h3>@lang('project.editHeadingGlobal')</h3>
				</div>
				<div class="panel-body">				
					<small class="text-danger">{{ $errors->first('title') }}</small>
					<div class="form-group {{ $errors->has('title') ? 'has-error has-feedback' : '' }}">
						{{ Form::label('title', trans('public.title')) }}
						{{ Form::text('title', $profil->task->title , array('class' => 'form-control', 'placeholder' => trans('public.title') )) }}
					</div>
					@if (helpers::checkEndDateTask($profil->task->id))
						<div class="form-group">
							{{ Form::label('noDate', trans('project.removeDate')) }}
							{{ Form::checkbox('noDate', 'check' ,false) }}
						</div>
						<small class="text-danger">{{ Session::get('date') }}</small>
						<div class="form-group">
							{{ Form::label('dayBegin', trans('task.dateBegin')) }}
							{{ Form::selectRange('dayBegin', 1, 31,   substr($profil->task->projects[0]->pivot->begin_date, 8,2))}}
							{{ Form::selectMonth('monthBegin', substr($profil->task->projects[0]->pivot->begin_date, 5,2)) }}
							{{ Form::selectRange('yearBegin', date('Y'), date('Y')+5, substr($profil->task->projects[0]->pivot->begin_date, 0,4)) }}
						</div>	

						<small class="text-danger">{{ $errors->first('dateEnd') }}</small>
						<div class="form-group">
							{{ Form::label('dayEnd', trans('task.dateEnd')) }}
							{{ Form::selectRange('dayEnd', 1, 31, substr($profil->task->projects[0]->pivot->end_date, 8,2))}}
							{{ Form::selectMonth('monthEnd', substr($profil->task->projects[0]->pivot->end_date, 5,2)) }}
							{{ Form::selectRange('yearEnd', date('Y'), date('Y')+5, substr($profil->task->projects[0]->pivot->end_date, 0,4)) }}
						</div>
					@else
						<div class="form-group">
							{{ Form::label('yesDate', trans('project.yesDate')) }}
							{{ Form::checkbox('yesDate', 'check' ,false) }}
						</div>
						<small class="text-danger">{{ Session::get('date') }}</small>
						<div class="form-group">
							{{ Form::label('dayBegin', trans('public.dateBegin')) }}
							{{ Form::selectRange('dayBegin', 1, 31,  date('j'))}}
							{{ Form::selectMonth('monthBegin', date('m')) }}
							{{ Form::selectRange('yearBegin', date('Y'), date('Y')+5,  date('Y')) }}
						</div>
						<small class="text-danger">{{ $errors->first('dateEnd') }}</small>
						<div class="form-group">
							{{ Form::label('dayEnd', trans('public.dateEnd')) }}
							{{ Form::selectRange('dayEnd', 1, 31,  date('j')+1)}}
							{{ Form::selectMonth('monthEnd', date('m')) }}
							{{ Form::selectRange('yearEnd', date('Y'), date('Y')+5, date('Y')) }}
						</div>
					@endif
				</div>
			</div>
			<div class="panel panel-primary floatl-800 w65-800 pd24 pdb0 mb24">
				<div class="panel-heading">
					<h3>{{trans('task.statusTask')}}</h3>
					<div class="clear panel-body">
						<small class="text-danger">{{ $errors->first('status') }}</small>
						@foreach ($profil->status as $status)
							<div class="floatl w20 w15-600">
								@if($status->id == $profil->task->status[0]->id)
									{{ Form::radio('status_id', $status->id, true, array('id' => 'status-'.$status->id, 'class' => 'picto')) }}
								@else
									{{ Form::radio('status_id', $status->id, false, array('id' => 'status-'.$status->id, 'class' => 'picto')) }}
								@endif
								<label class="floatl posrel z9 tac" for="status-{{ $status->id }}">
									<div class="hw40">{{ helpers::getStatusTask($status->id, true) }}</div>
								</label>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	{{ Form::close()}}
@stop
@extends('template.index')


@section('title')
	{{ $project->name }}
@stop

@section('content')
	{{ Form::open(array('route' => array('project.update', $project->generated_url), 'method' => 'PUT', 'class' => 'form-horizontal'))}}			
		<header class="article-header bg-bluebis mb24">
			<div class="wrap clear pd24-0">
				<h2 class="dis-ib col-white">@lang('public.editProject')</h2>
				{{ Form::submit(trans('public.saveAll'), array('class' => 'btn btn-primary saveAll floatr')) }}
			</div>
		</header>
		<div id="editprofilPanel">	
			<div class="wrap clear">
				@if(Session::has('status'))
					<div class="dis-b pd12-24 col-white alert bg-ok floatl-800 w65-800">
						{{ Session::get('status') }}
						<span class="dis-ib floatr col-white">{{ HTML::linkRoute('projectShow', trans('project.showProject'), $project->generated_url, array( 'class' => 'col-white' )) }}</span>
					</div>
				@endif
				@if(Session::has('error'))
					<div class="dis-b pd12-24 col-white alert bg-ko floatl-800 w65-800">{{ Session::get('error') }}</div>
				@endif	
				
				<div class="floatr-800 w35-800 pdl24-800 mb24">
					<div class="panel panel-primary pd24 pdb0 mb24">	
						<div class="panel-heading">
							<h3>{{trans('public.participants')}}</h3>
							<span class="dis-b"><small>{{trans('project.editUserLegend')}}</small></span>
						</div>					
						<div class="panel-body"> 
							@foreach ($project->users as $u)
								@if ($u->pivot->user_permission_id != 1)						
									<div class="itemlist bb1-grey">
										<div class="clear">
											{{ helpers::getAvatar($u->pivot->user_id, 'floatl round hw40 mrg24-0 divbg dis-ib') }}
											<h5 class="dis-ib username mrg12-0 mb0 pd12 pdb0">
												@if(helpers::checkPublicName($u->pivot->user_id))
													{{ helpers::checkPublicName($u->pivot->user_id) }}
												@else
													{{ $u->pivot->user_email }}
												@endif
											</h5>
											<div class="clear">
												@foreach ($permission as $p)
													@if ($p->id != 1)
													<span class="dis-ib floatl0">
														<?php if($p->id == $u->pivot->user_permission_id) : $rep = true; else : $rep = false; endif; ?>
														{{ Form::radio('permission'.$u->pivot->user_id, $p->id, $rep ,array('id' => $p->permission.$u->pivot->user_id, 'class' => 'op0 modern-radio' )) }} 
														<label class="posrel z9" for="{{ $p->permission.$u->pivot->user_id }}">{{ $p->name }}</label>
													</span>
													@endif
												@endforeach 

												{{ Form::checkbox('delete[]', $u->pivot->user_id, false,  array('id' => 'delete-'.$u->pivot->user_id, 'class' => 'op0 posabs') ) }}
												<div class="btn bg-ko">
													{{ Form::label('delete-'.$u->pivot->user_id, trans('public.delete')) }}
												</div>
											</div>											
										</div>
									</div>
								@endif
							@endforeach
						</div>
					</div>
					<div class="panel panel-primary pd24 pdb0 mb24">	
						<div class="panel-heading">
							<h3>{{trans('public.addParticipants')}}</h3>
							<span class="dis-b"><small>{{trans('project.addUserLegend')}}</small></span>
						</div>
						<div class="panel-body"> 
							@foreach ($userNotIn as $u)
								<div class="itemlist bb1-grey">
									<div class="clear">
										{{ Form::checkbox('participant[]', $u->id, false,  array('id' => $u->email, 'class' => 'picto floatl posabs') )}}
										<label class="mrg24-0 floatl posrel z9" for="{{ $u->email }}">
											{{ helpers::getAvatar($u->id, 'floatl round hw40 divbg dis-ib') }}											
										</label>
										<h5 class="dis-ib username mrg12-0 mb0 pd12 pdb0">
											@if(helpers::checkPublicName($u->id))
												{{ helpers::checkPublicName($u->id) }}
											@else
												{{ $u->email }}
											@endif
										</h5>
										<div class="clear">
											@foreach ($permission as $p)
												@if ($p->id != 1)
													<span class="dis-ib floatl">
														@if($p->id == 2)
															{{ Form::radio('permission'.$u->id, $p->id, true, array('id' => $p->permission.$u->id, 'class' => 'op0 modern-radio' )) }}
														@else
															{{ Form::radio('permission'.$u->id, $p->id, false, array('id' => $p->permission.$u->id, 'class' => 'op0 modern-radio' )) }}
														@endif
														<label class="posrel z9" for="{{ $p->permission.$u->id }}">{{ $p->name }}</label>
													</span>
												@endif
											@endforeach
										</div>
									</div>
								</div>
							@endforeach
						</div>
					</div>
					
					<div class="panel panel-primary pd24">	
						<div class="panel-heading">
							<h3>{{trans('public.chief')}}</h3>
						</div>
						<div class="panel-body"> 
							@foreach ($project->users as $u)
								@if ($u->pivot->user_permission_id === 1)
									{{ Form::radio('chief', $u->pivot->user_id, true,  array('id' => $u->pivot->user_email, 'class' => 'picto') )}}
								@else
									{{ Form::radio('chief', $u->pivot->user_id, false,  array('id' => $u->pivot->user_email, 'class' => 'picto') )}}
								@endif
								<label class="picto posrel z9" for="{{ $u->pivot->user_email }}">
									{{ helpers::getAvatar($u->pivot->user_id) }}	
								</label>
							@endforeach
						</div>
					</div>
				</div>
				
				<div class="panel panel-primary pd24 mb24 floatl-800 w65-800">	
					<div class="panel-heading">
						<h3 class="dis-ib">@lang('project.editHeadingGlobal')</h3>
					</div>
					<div class="panel-body"> 

						<small class="text-danger">{{ $errors->first('title') }}</small>
						<div class="form-group {{ $errors->has('title') ? 'has-error has-feedback' : '' }}">
							{{ Form::label('title', trans('public.title')) }}
							{{ Form::text('title', $project->name , array('class' => 'form-control', 'placeholder' => trans('public.title') )) }}
						</div>

						<small class="text-danger">{{ $errors->first('description') }}</small>
						<div class="form-group {{ $errors->has('description') ? 'has-error has-feedback' : '' }}">
							{{ Form::label('description', trans('public.description')) }}
							{{ Form::textArea('description', $project->description , array('class' => 'form-control', 'placeholder' => trans('public.description') )) }}
						</div>
					</div>
				</div>
				@if(helpers::checkEndDateProject($project->id))
					<div class="panel panel-primary pd24 mb24 floatl-800 w65-800">	
						<div class="panel-heading">
							<h3 class="dis-ib">{{trans('public.editDate')}}</h3>
							<div class="floatr">
								{{ Form::label('noDate', trans('project.removeDate')) }}
								{{ Form::checkbox('noDate', 'check' ,false) }}
							</div>
						</div>
						<div class="panel-body">
							<small class="text-danger">{{ Session::get('date') }}</small>
							<div class="form-group">
								{{ Form::label('dateBegin', trans('public.dateBegin')) }}
								{{ Form::selectRange('dayBegin', 1, 31,  substr($project->begin_date, 8, 2))}}
								{{ Form::selectMonth('monthBegin', substr($project->begin_date, 5, 2)) }}
								{{ Form::selectRange('yearBegin', date('Y'), date('Y')+5, substr($project->begin_date, 0, 4)) }}
							</div>
							<small class="text-danger">{{ $errors->first('dateEnd') }}</small>
							<div class="form-group">
								{{ Form::label('dateEnd', trans('public.dateEnd')) }}
								{{ Form::selectRange('dayEnd', 1, 31,  substr($project->end_date, 8, 2))}}
								{{ Form::selectMonth('monthEnd', substr($project->end_date, 5, 2)) }}
								{{ Form::selectRange('yearEnd', date('Y'), date('Y')+5, substr($project->end_date, 0, 4)) }}
							</div>
						</div>						
					</div>
				@else
					<div class="panel panel-primary pd24 mb24 floatl-800 w65-800">	
						<div class="panel-heading">
							<h3 class="dis-ib">{{trans('project.addDate')}}</h3>
							<div class="floatr">
								{{ Form::label('yesDate', trans('project.yesDate')) }}
								{{ Form::checkbox('yesDate', 'check' ,false) }}
							</div>	
						</div>
						<div class="panel-body">
							<small class="text-danger">{{ Session::get('date') }}</small>
							<div class="form-group">
								{{ Form::label('dateBegin', trans('public.dateBegin')) }}
								{{ Form::selectRange('dayBegin', 1, 31,  date('j'))}}
								{{ Form::selectMonth('monthBegin', date('m')) }}
								{{ Form::selectRange('yearBegin', date('Y'), date('Y')+5,  date('Y')) }}
							</div>
							<small class="text-danger">{{ $errors->first('dateEnd') }}</small>
							<div class="form-group">
								{{ Form::label('dateEnd', trans('public.dateEnd')) }}
								{{ Form::selectRange('dayEnd', 1, 31,  date('j')+1)}}
								{{ Form::selectMonth('monthEnd', date('m')) }}
								{{ Form::selectRange('yearEnd', date('Y'), date('Y')+5, date('Y')) }}
							</div>
						</div>						
					</div>
				@endif
			</div>	
		</div>
	{{ Form::close() }}
	<script src="{{public_path()}}\js\project.js"></script>
@stop
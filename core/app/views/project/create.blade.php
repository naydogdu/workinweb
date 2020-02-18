@extends('template.index')

@section('title')
	@lang('project.create')
@stop

@section('content')
	{{ Form::open(array('route' => array('project.store'), 'method' => 'post', 'class' => 'form-horizontal'))}}
		<header class="article-header bg-bluebis mb24">
			<div class="wrap clear pd24-0">
				<h2 class="dis-ib col-white">@lang('public.createProject')</h2>
				{{ Form::submit(trans('public.createProject'), array('class' => 'btn btn-primary saveAll floatr')) }}
			</div>
		</header>
		<div class="wrap clear">
			@if(Session::has('status'))
				<div class="dis-b pd12-24 col-white alert bg-ok">
					{{ Session::get('status') }}
				</div>
			@endif
			@if(Session::has('error'))
				<div class="dis-b pd12-24 col-white alert bg-ko">{{ Session::get('error') }}</div>
			@endif	
			<div class="panel panel-primary clear pd24 mb24">
				<div class="floatl-800 w65-800 mb36 mb0-800">
					<div class="panel-heading">					
						<h3>@lang('project.editHeadingGlobal')</h3>
					</div>
					<div class="panel-body">				
						<small class="text-danger">{{ $errors->first('title') }}</small>
						<div class="form-group {{ $errors->has('title') ? 'has-error has-feedback' : '' }}">
							{{ Form::label('title', trans('public.title')) }}
							{{ Form::text('title', null , array('class' => 'form-control', 'placeholder' => trans('public.title') )) }}
						</div>

						<small class="text-danger">{{ $errors->first('description') }}</small>
						<div class="form-group {{ $errors->has('description') ? 'has-error has-feedback' : '' }}">
							{{ Form::label('description', trans('public.description')) }}
							{{ Form::textArea('description', null , array('class' => 'form-control', 'placeholder' => trans('public.description') )) }}
						</div>
					</div>
					<div class="panel-body form-group">
						{{ Form::label('TypeProject', trans('project.titleTypeProject')) }}
						<div class="dis-ib">
						@foreach ($typeProject as $t)
							@if ($t->name == 'Web')
								{{ Form::radio('TypeProject' , $t->id, true, array('id' => $t->name)) }}
							@else
								{{ Form::radio('TypeProject' , $t->id, false, array('id' => $t->name)) }}
							@endif
							{{ Form::label($t->name)}}
						@endforeach
						</div>
					</div>
				</div>
				<div class="floatr-800 w35-800 pdl24-800 mb24">
					<div class="panel panel-primary pdl24-800 mb24">	
						<div class="panel-heading">					
							<h3>@lang('project.editDatesInfos')</h3>
						</div>	
						<div class="panel-body">
							<small class="text-danger">{{ Session::get('date') }}</small>
							<div class="">
								{{ Form::label('dayBegin', trans('public.dateBegin')) }}
							</div>	
							{{ Form::selectRange('dayBegin', 1, 31,  date('j'))}}
							{{ Form::selectMonth('monthBegin', date('m')) }}
							{{ Form::selectRange('yearBegin', date('Y'), date('Y')+5, date('Y')) }}
						</div>	
						<div class="panel-body">
							<small class="text-danger">{{ $errors->first('dateEnd') }}</small>
							<div class="">
								{{ Form::label('dayEnd', trans('public.dateEnd')) }}
							</div>	
							{{ Form::selectRange('dayEnd', 1, 31,  date('j')+1)}}
							{{ Form::selectMonth('monthEnd', date('m')) }}
							{{ Form::selectRange('yearEnd', date('Y'), date('Y')+5, date('Y')) }}
						</div>
						<div class="panel-body">
							<div class="">
								{{ Form::label('noDate', trans('project.noDate')) }}
								{{ Form::checkbox('noDate', 'check' ,false) }}
							</div>	
						</div>
					</div>
				</div>	
			</div>
		</div>
		<div class="wrap clear">
			<div class="panel panel-primary pd24 mb24">
				<div class="panel-heading">					
					<h3>{{trans('public.addParticipants')}}</h3>
					<span class="dis-b"><small>{{trans('project.addUserLegend')}}</small></span>
				</div>	
				
				<div class="clear panel-body"> 
					@foreach ($profil as $a)						
						<div class="w50-600 floatl-600 w30-960 w25-1200">{{ Form::checkbox('participant[]', $a->user['id'], false,  array('id' => $a->user['email'], 'class' => 'picto floatl posabs') )}}
							<label class="mrg24-0 floatl posrel z9" for="{{ $a->user['email'] }}">
								{{ helpers::getAvatar($a->user['id'], 'floatl round hw40 divbg dis-ib') }}
							</label>
							<h5 class="dis-ib username mrg12-0 mb0 pd12 pdb0">
								@if(helpers::checkPublicName($a->user['id']))
									{{ helpers::checkPublicName($a->user['id']) }}
								@else
									{{ $a->user['email'] }}
								@endif
							</h5>
							<div class="clear">
								@foreach ($permission as $p)
									@if ($p->id != 1)								
										<span class="dis-ib floatl">
											@if($p->id == 2)
												{{ Form::radio('permission'.$a->user['id'], $p->id, true, array('id' => $p->permission.$a->user['id'], 'class' => 'op0 modern-radio' )) }}
											@else
												{{ Form::radio('permission'.$a->user['id'], $p->id, false, array('id' => $p->permission.$a->user['id'], 'class' => 'op0 modern-radio' )) }}
											@endif
											<label class="posrel z9" for="{{ $p->permission.$a->user['id'] }}">{{ $p->name }}</label>
										</span>
									@endif
								@endforeach 
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	{{ Form::close() }}
	<script src="{{public_path()}}\js\project.js"></script>
@stop
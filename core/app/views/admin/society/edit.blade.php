@extends('template.index')

@section('content')
    <div id="editUserPanel">
		<div class="wrap clear">
			@if(Session::has('status'))
				<div class="dis-b pd12-24 col-white alert bg-ok">{{ Session::get('status') }}</div>
			@endif
			<div class="panel panel-primary pd24">	
				<div class="panel-heading">
					{{ Form::open(array('url' => 'society-admin/' . $society->id, 'method' => 'put', 'class' => 'form-horizontal panel')) }}
					<div class="floatr">
						{{ link_to_route('society-admin.index', trans('pagination.backTo'), null, array('class' => 'btn btn-success btn-block')) }}
						{{ Form::submit( trans('admin.submit'), array('class' => 'btn btn-primary')) }}
					</div>
					<h3>{{ trans('admin.editSociety') }} : {{ $society->name }}</h3>
				</div>
				<div class="panel-body"> 
						<small class="text-danger">{{ $errors->first('nameSociety') }}</small>
						<div class="form-group {{ $errors->has('nameSociety') ? 'has-error has-feedback' : '' }}">
							{{ Form::label('nameSociety', trans('admin.society')) }}
							{{ Form::text('nameSociety', $society->name, array('class' => 'form-control', 'placeholder' => trans('admin.nameSociety') )) }}
						</div>
						<small class="text-danger">{{ $errors->first('siret') }}</small>
						<div class="form-group {{ $errors->has('siret') ? 'has-error has-feedback' : '' }}">
							{{ Form::label('siret', trans('admin.siret')) }}
							{{ Form::text('siret', $society->siret , array('class' => 'form-control', 'placeholder' => trans('admin.siret') )) }}
						</div>
						<small class="text-danger">{{ $errors->first('creator') }}</small>
						<div class="form-group {{ $errors->has('creator') ? 'has-error has-feedback' : '' }}">
							{{ Form::label('creator', trans('admin.creator')) }}
							{{ Form::select('creator', array(trans('admin.users') => $usersList), $society->creator_id) }}
						</div>
				</div>
				<div class="form-group">
				</div>
			</div>

			<div class="panel panel-primary pd24 mb24">
				<div class="panel-heading">					
					<h3>{{trans('admin.userList')}}</h3>
					<span class="dis-b"><small>{{trans('admin.deleteUserLegend')}}</small></span>
				</div>
				<div class="clear panel-body"> 
					@foreach ($society->users as $user)						
						<div class="w50-600 floatl-600 w30-960 w25-1200">{{ Form::checkbox('participantDelete[]', $user->id, false,  array('id' => $user->email, 'class' => 'picto floatl posabs') )}}
							<label class="mrg24-0 floatl posrel z9" for="{{ $user->email }}">
								{{ helpers::getAvatar($user->id, 'floatl round hw40 divbg dis-ib') }}
							</label>
							<h5 class="dis-ib username mrg12-0 mb0 pd12 pdb0">
								<label for="{{ $user->email }}">
									{{ helpers::checkPublicName($user->id) }}
								</label>
								@if(helpers::checkIfOwnerSociety($user->id))
									<span class="dis-b"><small>{{ trans('admin.chief') }}</small></span>
								@endif
							</h5>
						</div>
					@endforeach
				</div>
			</div>

			<div class="panel panel-primary pd24 mb24">
				<div class="panel-heading">					
					<h3>{{trans('admin.addUser')}}</h3>
					<span class="dis-b"><small>{{trans('admin.addUserLegend')}}</small></span>
				</div>
				<div class="clear panel-body"> 
					<small class="text-danger">{{ $errors->first('email') }}</small>
					<div class="form-group {{ $errors->has('email') ? 'has-error has-feedback' : '' }}">
						{{ Form::email('email', null, array('class' => 'form-control', 'placeholder' => trans('admin.email') )) }}
					</div>
					<div class="form-group {{ $errors->has('email') ? 'has-error has-feedback' : '' }}">
						{{ Form::email('email_confirmation', null, array('class' => 'form-control', 'placeholder' => trans('admin.emailConfirmation') )) }}
					</div>
				</div>
				<div class="clear panel-body"> 
					@foreach ($usersNoSociety as $user)						
						<div class="w50-600 floatl-600 w30-960 w25-1200">{{ Form::checkbox('participant[]', $user->id, false,  array('id' => $user->email, 'class' => 'picto floatl posabs') )}}
							<label class="mrg24-0 floatl posrel z9" for="{{ $user->email }}">
								{{ helpers::getAvatar($user->id, 'floatl round hw40 divbg dis-ib') }}
							</label>
							<h5 class="dis-ib username mrg12-0 mb0 pd12 pdb0">
								<label for="{{ $user->email }}">
									{{ helpers::checkPublicName($user->id) }}
								</label>
							</h5>
						</div>
					@endforeach
				</div>
				{{ Form::close() }}
			</div>


			<div class="panel panel-bottom pd24">
				<a href="javascript:history.back()" class="btn btn-primary">
					<span class="glyphicon glyphicon-circle-arrow-left"></span> {{ trans('pagination.backTo') }}
				</a>
			</div>
		</div>
	</div>
@stop
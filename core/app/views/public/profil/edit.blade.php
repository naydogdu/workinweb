@extends('template.index')

@section('title')
	{{ trans('profil.edit')}}
@stop

@section('content')
    <div id="editprofilPanel">
		<div class="wrap clear">
			@if(Session::has('status'))
				<div class="dis-b pd12-24 col-white alert bg-ok floatl-800 w65-800">{{ Session::get('status') }}</div>
			@endif
			@if(Session::has('error'))
				<div class="dis-b pd12-24 col-white alert bg-ko floatl-800 w65-800">{{ Session::get('error') }}</div>
			@endif
			<div class="floatr-800 w35-800 pdl24-800 mb24">
				<div class="panel panel-primary pd24">	
					<div class="panel-heading">
						<h3>@lang('profil.avaGalery')</h3>
					</div>				
					<div class="panel-body"> 
						@if(isset($profil->uploads['0']))
							{{ Form::open(array('method' => 'PUT', 'route' => array('profil.update', $profil->id), 'class' => 'avalist dis-ib')) }}
								@foreach ($profil->uploads as $a)						
									@if($profil->avatar_id == $a->id)
										{{Form::radio('avatar_id', $a->id, true, array('id' => $a->name, 'class' => 'picto') )}}
									@else
										{{Form::radio('avatar_id', $a->id, false,  array('id' => $a->name, 'class' => 'picto') )}}
									@endif
									<label class="picto posrel z9" for="{{ $a->name }}">
										<div style="background-image: url( {{ $a->url }} );" class="round hw80 divbg dis-ib"></div>
									</label>
								@endforeach
								<div class="pd24-0 pdb0">{{ Form::submit( trans('profil.update'), array('class' => 'btn btn-block mb0') ) }}</div>
							{{ Form::close() }}
						@else
							{{ trans('admin.noAvatar') }}
						@endif								
						<div class="form-group avadelete">
							@if(isset($profil->uploads['0']))
								@foreach ($profil->uploads as $a)
									<div class="hw80 dis-ib avadel-area">
										{{ Form::open(array('method' => 'DELETE', 'route' => array('profil.destroy', $a->id), 'class' => 'dis-ib')) }}
											{{ Form::submit( 'x', 
												array(
													'class' => 'close-icon bg-whiteter col-white mb0', 
													'onclick' => 'return confirm("' . trans('profil.areYouSureDeleteAvatar') . '")'
												) 
											) }}
										{{ Form::close() }}
									</div>
								@endforeach
							@endif
						</div>
					</div>
				</div>
			</div>	
			<div class="panel panel-primary pd24 mb24 floatl-800 w65-800">	
				<div class="panel-heading">
					<h3 class="dis-ib">@lang('profil.edit')</h3>
					<a href="{{ URL::route('profil.show', $profil->id) }}" class="floatr dis-ib"><i class="fa fa-eye"></i> {{ trans('profil.viewProfil') }}</a>
				</div>				
				<div class="panel-body"> 
					{{ Form::open(array('route' => array('profil.update', $profil->id), 'files' => true ,'method' => 'put', 'class' => 'form-horizontal panel')) }}
						<small class="text-danger">{{ $errors->first('first_name') }}</small>
						<div class="form-group {{ $errors->has('first_name') ? 'has-error has-feedback' : '' }}">
							{{ Form::label('first_name', trans('profil.firstName')); }}
							{{ Form::text('first_name', $profil->first_name, array('class' => 'form-control', 'placeholder' => trans('profil.firstName') )) }}
						</div>
						
						<small class="text-danger">{{ $errors->first('last_name') }}</small>
						<div class="form-group {{ $errors->has('last_name') ? 'has-error has-feedback' : '' }}">
							{{ Form::label('last_name', trans('profil.lastName')); }}
							{{ Form::text('last_name', $profil->last_name, array('class' => 'form-control', 'placeholder' => trans('profil.lastName') )) }}
						</div>
						
						<div class="form-group">
							{{ Form::label('gender', trans('profil.gender')); }}
							{{ Form::select('gender', array(trans('profil.gender') => array('null' => trans('profil.notSpecified'),'male' => trans('profil.male'), 'female' => trans('profil.female') )), $profil->gender);}}
						</div>

						<small class="text-danger">{{ $errors->first('birthday') }}</small>
						<div class="form-group">
							{{ Form::label('birthday', trans('profil.birthday')); }}
							{{ Form::selectRange('day', 1, 31, $profil->day)}}
							{{ Form::selectMonth('month', $profil->month) }}
							{{ Form::selectRange('year', date("Y"), 1900, $profil->year) }}
						</div> 
						
						<small class="text-danger">{{ $errors->first('occupation') }}</small>
						<div class="form-group">
							{{ Form::label('occupation', trans('profil.occupation')); }}
							{{ Form::text('occupation', $profil->occupation, array('class' => 'form-control', 'placeholder' => trans('profil.occupation') )) }}
						</div>
						
						<small class="text-danger">{{ $errors->first('avatar') }}</small>
						<div class="form-group {{ $errors->has('avatar') ? 'has-error has-feedback' : '' }}">
							{{ Form::label('avatar', trans('profil.addAvatar')); }}
							{{ Form::file('avatar'); }}
						</div> 
						<div class="form-group">
							{{ Form::submit( trans('profil.submit'), array('class' => 'btn btn-primary')) }}
							{{ Form::close() }}
						</div>			
				</div>
				<div class="panel-heading">
					<h3 class="dis-ib">@lang('profil.editAccount')</h3>
				</div>
				<div class="panel-body"> 
					{{ Form::open(array('route' => array('user.update', $profil->user_id), 'files' => true ,'method' => 'put', 'class' => 'form-horizontal panel')) }}
						<small class="text-danger">{{ $errors->first('email_1') }}</small>
						<div class="form-group {{ $errors->has('email_1') ? 'has-error has-feedback' : '' }}">
							{{ Form::label('email_1', trans('admin.email')); }}
							{{ Form::email('email_1', null, array('class' => 'form-control', 'placeholder' => $profil->user->email )) }}
						</div>
						<div class="form-group">
							{{ Form::label('email_1_confirmation', trans('admin.emailConfirmation')); }}
							{{ Form::email('email_1_confirmation', null, array('class' => 'form-control', 'placeholder' => trans('admin.emailConfirmation') )) }}
						</div>
						<small class="text-danger">{{ $errors->first('oldPassword') }}</small>
						<div class="form-group {{ $errors->has('OldPassword') ? 'has-error has-feedback' : '' }}">
							{{ Form::label('oldPassword', trans('admin.oldPassword')); }}
							{{ Form::password('oldPassword' ,array('class' => 'form-control', 'placeholder' => trans('admin.oldPassword') )) }}
						</div>
						<small class="text-danger">{{ $errors->first('password_1') }}</small>
						<div class="form-group {{ $errors->has('password_1') ? 'has-error has-feedback' : '' }}">
							{{ Form::label('password_1', trans('admin.password')); }}
							{{ Form::password('password_1' ,array('class' => 'form-control', 'placeholder' => trans('admin.newPassword') )) }}
						</div>
						<div class="form-group">
							{{ Form::label('password_1_confirmation', trans('admin.confirmPassword')); }}
							{{ Form::password('password_1_confirmation', array('class' => 'form-control', 'placeholder' => trans('admin.confirmPassword') )) }}
						</div>
						<div class="form-group">
							{{ Form::submit( trans('profil.submit'), array('class' => 'btn btn-primary')) }}
							{{ Form::close() }}
						</div>	
				</div>
			</div>
		</div>
		<div class="wrap clear">
			<div class="panel panel-bottom pd24">
				<a href="javascript:history.back()" class="btn btn-primary">
					<span class="glyphicon glyphicon-circle-arrow-left"></span> {{ trans('pagination.backTo') }}
				</a>
			</div>
		</div>
	</div>
@stop
@extends('template.index')

@section('content')
	<div id="userGlobalList">
		<div class="wrap clear">
			@if(Session::has('status'))
				<div class="dis-b pd12-24 col-white alert bg-ok">{{ Session::get('status') }}</div>
			@endif
			<div class="panel panel-primary pd24">
				<div class="panel-heading">
					<h3 class="panel-title">{{ trans('admin.adminList') }}</h3>
				</div>			  
				<div class="panel-body">
				@foreach($society as $s)
					@foreach($s->users as $user)
						@if ($user->role_id == 1)
							<div class="itemlist bb1-grey clear pd12-0 user-id_{{ $user->id }} user-role_{{ $user->roles_meta_id }}">
								<span class="dis-ib pd8-0"><a class="floatl pd0-24 pdl0" href="{{ URL::route('user.show', $user->id)}}">{{ $user->email }}</a></span>
								<div class="floatr-800">
									{{ link_to_route('user.show', trans('admin.see'), array($user->id), array('class' => 'btn btn-success btn-block')) }}
									{{ link_to_route('profil.edit', trans('admin.edit'), array($user->id), array('class' => 'btn btn-success btn-block')) }}
									{{ link_to_route('user.edit', trans('admin.update'), array($user->id), array('class' => 'btn btn-success btn-block')) }}
								</div>
							</div>
						@endif
					@endforeach
				@endforeach
				</div>
			</div>
			
			@foreach($society as $s)
				<div class="panel panel-primary pd24">
					<div class="panel-heading">
						<h3 class="panel-title">{{ $s->name }}</h3>
					</div>			  
					<div class="panel-body"> 
						@foreach($s->users as $user)
							<div class="itemlist bb1-grey clear pd12-0 user-id_{{ $user->id }} user-role_{{ $user->roles_meta_id }}">
								<span class="dis-ib pd8-0"><a class="floatl pd0-24 pdl0" href="{{ URL::route('user.show', $user->id)}}">{{ $user->email }}</a></span>
								<div class="floatr-800">
									{{ link_to_route('user.show', trans('admin.see'), array($user->id), array('class' => 'btn btn-success btn-block')) }}
									{{ link_to_route('profil.edit', trans('admin.edit'), array($user->id), array('class' => 'btn btn-success btn-block')) }}
									{{ link_to_route('user.edit', trans('admin.update'), array($user->id), array('class' => 'btn btn-sucess btn-block')) }}
									@if( $user->role_id !== 1 )
										@if (helpers::checkTaskUser($user->id))
											{{ Form::submit( trans('admin.deleteUser'), 
												array(
													'class' => 'btn btn-sucess btn-block', 
													'onclick' => 'return alert("' . trans('admin.youCantDeleteUser') . '")'
												) 
											) }}
										@elseif (helpers::checkIfOwnerSociety($user->id))
											{{ Form::submit( trans('admin.deleteUser'), 
												array(
													'class' => 'btn btn-sucess btn-block', 
													'onclick' => 'return alert("' . trans('admin.youCantDeleteUserSociety') . '")'
												) 
											) }}
										@else
										{{ Form::open(array('method' => 'DELETE', 'route' => array('user.destroy', $user->id), 'class' => 'dis-ib')) }}
											{{ Form::submit( trans('admin.deleteUser'), 
												array(
													'class' => 'btn btn-sucess btn-block', 
													'onclick' => 'return confirm("' . trans('admin.areYouSureDeleteUser') . '")'
												) 
											) }}
										@endif
										{{ Form::close() }}
									@endif
								</div>
							</div>
						@endforeach
					</div>
				</div>
			@endforeach

			@if (isset($users[0]))
			<div class="panel panel-primary pd24">
				<div class="panel-heading">
					<h3 class="panel-title">{{ trans('admin.noSociety') }}</h3>
				</div>			  
				<div class="panel-body"> 
					@foreach($users as $user)
						<div class="itemlist bb1-grey clear pd12-0 user-id_{{ $user->id }} user-role_{{ $user->roles_meta_id }}">
							<span class="dis-ib pd8-0"><a class="floatl pd0-24 pdl0" href="{{ URL::route('user.show', $user->id)}}">{{ $user->email }}</a></span>
							<div class="floatr-800">
								{{ link_to_route('user.show', trans('admin.see'), array($user->id), array('class' => 'btn btn-success btn-block')) }}
								{{ link_to_route('profil.edit', trans('admin.edit'), array($user->id), array('class' => 'btn btn-success btn-block')) }}
								{{ link_to_route('user.edit', trans('admin.update'), array($user->id), array('class' => 'btn btn-sucess btn-block')) }}
								@if( $user->role_id !== 1 )
									{{ Form::open(array('method' => 'DELETE', 'route' => array('user.destroy', $user->id), 'class' => 'dis-ib')) }}
										{{ Form::submit( trans('admin.deleteUser'), 
											array(
												'class' => 'btn btn-sucess btn-block', 
												'onclick' => 'return confirm("' . trans('admin.areYouSureDeleteUser') . '")'
											) 
										) }}
									{{ Form::close() }}
								@endif
							</div>
						</div>
					@endforeach
				</div>
			</div>
			@endif
			<div class="panel panel-bottom pd24">
				{{ link_to_route('user.create', trans('admin.addUser'), null, array('class' => 'btn btn-primary')) }}
				{{ $society->links(); }}
			</div>
		</div>
	</div>
@stop
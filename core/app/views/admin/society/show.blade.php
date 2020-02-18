@extends('template.index')
@section('title')
	{{ $society->name }}
@stop
@section('content')
	<div id="userGlobalList">
		<div class="wrap clear">
			@if(Session::has('status'))
				<div class="dis-b pd12-24 col-white alert bg-ok">{{ Session::get('status') }}</div>
			@endif
			<div class="panel panel-primary pd24">
				<div class="panel-heading">
					<h3 class="panel-title">{{ $society->name }}</h3>
				</div>
			</div>
			<div class="panel panel-primary pd24">			  
				<div class="panel-body">
					<p>{{ trans('admin.creator') }} : <a href="{{ URL::route('user.show', $society->creator_id)}}">{{ helpers::checkPublicName($society->creator_id) }}</a></p>
					<p>{{ trans('admin.siret') }} : {{ $society->siret }}</p>
					<p>{{ trans('admin.numberMember') }} : {{ helpers::getNumberPeopleSociety($society->id) }}</p>
				</div>
			</div>
			<div class="panel panel-primary pd24">
				<div class="panel-heading">
					<h3 class="panel-title">{{ trans('admin.userList') }}</h3>
				</div>
			</div>
			@foreach ($society->users as $user)
				<div class="panel panel-primary pd12">
					<span class="dis-ib pd8-0"><a class="floatl pd0-24 pdl0" href="{{ URL::route('user.show', $user->id)}}">{{ helpers::checkPublicName($user->id) }}</span></a>
					<a class="floatl pd0-24 pdl0" href="{{ URL::route('user.show', $user->id)}}">{{ helpers::getAvatar($user->id) }}</a>
					<div class="floatr-800">
						{{ link_to_route('user.show', trans('admin.see'), array($user->id), array('class' => 'btn btn-success btn-block')) }}
						{{ link_to_route('profil.edit', trans('admin.edit'), array($user->id), array('class' => 'btn btn-success btn-block')) }}
						{{ link_to_route('user.edit', trans('admin.update'), array($user->id), array('class' => 'btn btn-success btn-block')) }}
					</div>
				</div>
			@endforeach
		</div>
	</div>
@stop
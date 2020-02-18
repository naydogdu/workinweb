@extends('template.index')

@section('content')
	<div id="userGlobalList">
		<div class="wrap clear">
			@if(Session::has('status'))
				<div class="dis-b pd12-24 col-white alert bg-ok">{{ Session::get('status') }}</div>
			@endif
			<div class="panel panel-primary pd24">
				<div class="panel-heading">
					<h3 class="panel-title">{{ trans('admin.societysList') }}</h3>
					<div class="floatr-800">
						{{ link_to_route('society-admin.create', trans('admin.addSociety'), null, array('class' => 'btn btn-primary')) }}
					</div>
				</div>
			</div>
			<div class="panel panel-primary pd24">			  
				<div class="panel-body">
				@foreach ($societys as $society)
					<div class="itemlist bb1-grey clear pd12-0">
						<div class="floatr-800">
							{{ link_to_route('society-admin.show', trans('admin.see'), $society->id, array('class' => 'btn btn-success btn-block')) }}
							{{ link_to_route('society-admin.edit', trans('admin.edit'), $society->id, array('class' => 'btn btn-success btn-block')) }}

							{{ Form::open(array('method' => 'DELETE', 'route' => array('society-admin.destroy', $society->id), 'class' => 'dis-ib')) }}
										{{ Form::submit( trans('admin.deleteSociety'), 
											array(
												'class' => 'btn btn-sucess btn-block', 
												'onclick' => 'return confirm("' . trans('admin.areYouSureDeleteSociety') . '")'
											) 
										) }}
						{{ Form::close() }}
						</div>
						{{ link_to_route('society-admin.show', $society->name, $society->id) }} -- 
						{{ trans('admin.creator') }} : <a href="{{ URL::route('user.show', $society->creator_id)}}">{{ helpers::checkPublicName($society->creator_id) }}</a> --
						{{ trans('admin.numberMember') }} : {{ helpers::getNumberPeopleSociety($society->id) }}
					</div>
				@endforeach
				</div>
			</div>
		</div>
	</div>
@stop
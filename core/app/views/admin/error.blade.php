@extends('template.index')

@section('content')
	<div id="editUserPanel">
		<div class="wrap clear">
			<div class="panel panel-primary pd24">	
				<div class="panel-heading">
					<h3>{{ trans('error.dbAccessTitle') }}</h3>
				</div>
				<div class="panel-body"> 
					{{ trans('error.dbAccess') }}
				</div>
			</div>	
		</div>
	</div>
@stop
@extends('template.index')

@section('title')
	{{ 'Home Page' }}
@stop

@section('content')
	<div id="editUserPanel">
		<div class="wrap clear">
			<div class="panel panel-primary pd24">	
				<div class="panel-heading">
					<h3>{{ 'Tableau de bord' }}</h3>
				</div>
				<div class="panel-body">
					<h4>{{ link_to_route('user.index', trans('admin.users'), null) }} </h4>
					<h4>{{ link_to_route('project-admin.index', trans('admin.projects'), null) }} </h4>
					<h4>{{ link_to_route('society-admin.index', trans('admin.society'), null) }} </h4>
					<!--<h4>{{ link_to_route('taskpublic-admin.index', trans('admin.indexTask'), null) }} </h4>-->

				</div>

			</div>	
		</div>
	</div>
@stop
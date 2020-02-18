@extends('template.index')

@section('title')
	{{ $ticket->title }}
@stop

@section('content')
	<div class="wrap clear">
		<div class="panel panel-primary pd24">	
			<div class="panel-heading">
				<h3>{{ $ticket->title }}</h3>
			</div>
			<div class="panel-body"> 
				<p>{{ $ticket->content }}</p>
			</div>
		</div>	
	</div>
@stop
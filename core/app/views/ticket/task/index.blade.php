@extends('template.index')

@section('title')
	{{ $task->title }}
@stop

@section('content')	
	<header class="article-header bg-bluebis mb24">
		<div class="wrap clear pd24-0">
			<h2 class="dis-ib col-white">{{ $task->title }}</h2>
			{{ link_to_route('project.show', trans('pagination.backToProject'), $task->generated_url , array('class' => 'btn floatr')) }}
		</div>
	</header>
	<div class="wrap min640 clear">
		@if(Session::has('status'))
			<div class="dis-b pd12-24 col-white alert bg-ok">
				{{ Session::get('status') }}
			</div>
		@endif
		@if( !empty($errors->first()) )
			<div class="dis-b pd12-24 col-white alert bg-ko">{{ $errors->first() }}</div>
		@endif	
		@if( !empty($task->tickets[0]) )
			@foreach($task->tickets as $ticket)
				<div class="panel bb1-grey pd24 ticketshow">	
					{{ helpers::getAvatar($ticket->author_id) }}
					<small class="dis-ib pdl6 col-grey">
						{{ trans('public.ticketTitle', ['user' => helpers::checkPublicName($ticket->author_id)]) }}
					</small>
					<small class="floatr col-grey">
						<i class="fa fa-clock-o"></i> {{ trans('public.ticketTime', ['date' => date('d/m/Y',strtotime($ticket->updated_at)), 'time' => date('h:i',strtotime($ticket->updated_at))]) }}
					</small>
					<div class="mrg12-0 mb0"> 
						<p>{{ $ticket->content }}</p>
					</div>
				</div>	
			@endforeach
			
		@endif
		<div class="panel pd24 ticketform">
			{{ helpers::getTicketForm($task->id, 'task') }}
		</div>
	</div>
@stop

<?php
use Lib\Validation\TicketCreateValidator as TicketCreateValidator;

class TaskTicketController extends BaseController {
	
	protected $ticket_validation;
	
	public function __construct( TicketCreateValidator $ticket_validation )
	{
		$this->ticket_validation = $ticket_validation;
	}
	
    public function index($taskId)
    {
        $task = Task::with('tickets')->find($taskId);
        $project = Task::findOrFail($taskId)->projects()->firstOrFail();
        $task->generated_url = $project->generated_url;
		return View::make('ticket.task.index', compact('task'));
    }
	
	public function create($taskId)
    {
		return Redirect::route( 'task.tickets.index', array($taskId) );
    }
	
	public function store($taskId)
	{
		if ($this->ticket_validation->fails()) {
            return Redirect::back()
            ->withErrors($this->ticket_validation->errors())
            ->withInput();
        } else {      
			$ticket = new Ticket;
			$ticket->content = Input::get('content');
			$ticket->ticketable_id = $taskId;
			$ticket->ticketable_type = 'task';
			$ticket->author_id = Auth::id();
			$ticket->save();
			
        	return Redirect::route('task.tickets.index', array('id' => $taskId))
        	->with('status', Lang::get('ticket.storeSuccess'));      	
        } 
	}
}
<?php
use Lib\Gestion\TaskGestion as TaskGestion;
use Lib\Validation\TaskCreateValidator as CreateValidation;

class TaskController extends BaseController {

	protected $task_gestion;
	protected $create_validation;

	public function __construct(TaskGestion $task_gestion, CreateValidation $create_validation)
	{
		$this->beforeFilter('user');
		$this->task_gestion = $task_gestion;
		$this->create_validation = $create_validation;
	} 

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$idProject = Input::get('id');
		$project = Project::find($idProject);

		if(null !== Input::get('id')) 
		{
			if (helpers::getPermission(Auth::id(), $project->generated_url) == 1 || Auth::user()->role_id == 1) // Filtre administrateur ou chef de projet
			{
				return View::make('task.create', $this->task_gestion->create($idProject));
			}
			else 
			{
				return Redirect::back();
			}
		}
		else {
			return Redirect::back();
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$idProject = Input::get('id');
		if($this->create_validation->fails()) 
		{
			return Redirect::back()
            ->withErrors($this->create_validation->errors())
            ->withInput();
        } else {
        	if($this->task_gestion->store($idProject))
        	{
        		return Redirect::back()
        		->with('status', Lang::get('task.storeSuccess'));
        	} else {
        		return Redirect::back()
        		->with('date', Lang::get('task.errorDate'))
        		->withInput();	 
			}
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($idTask)
	{
		$idProject = Input::get('id');
		return View::make('task.edit', $this->task_gestion->edit($idTask, $idProject));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($idTask)
	{
		$idProject = Input::get('id');
		if($this->create_validation->fails()) 
		{
			return Redirect::back()
            ->withErrors($this->create_validation->errors())
            ->withInput();
        } else {
        	if($this->task_gestion->update($idTask, $idProject))
        	{
        		return Redirect::back()
        		->with('status', Lang::get('task.editSuccess'));
        	} else {
        		return Redirect::back()
        		->with('date', Lang::get('task.errorDate'))
        		->withInput();	 
			}
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$task = Task::withTrashed()->with('tickets')->findOrFail($id);
		if ($task->trashed()) {
			$idProject = Input::get('id');

			if(count($task->users) > 1) {
					foreach ($task->users as $user) {
						$user_ = User::findOrFail($user->id);
						$user_->tasks()->detach($task->id);
					}
				}
			if(count($task->tickets) > 1 ) {
				foreach ($task->tickets as $ticket) {
					$ticket_ = Ticket::find($ticket->id);
					$ticket_->delete();
				}
			}
			$project = Project::find($idProject);
			$project->tasks()->detach($id); // delete from the pivot task_project table
			$task->forceDelete();
		} else {
			$task->delete();
		}
			
		return Redirect::back();
	}

	// Restoration d'un brouillon
	public function restore($id)
	{
		$task = Task::onlyTrashed()->find($id)->restore();
		return Redirect::back();
	}

	public function addPublicTask($id)
	{
		$project = Project::findOrFail($id);
		if(Input::has('addTask')){
			foreach (Input::get('addTask') as $t) {
				$taskPublic = TasksPublic::findOrFail($t);
				$task = new Task;
				$task->title = $taskPublic->title;
				$task->save();
				$theTask = Task::where('title', '=', $taskPublic->title)->orderBy('id', 'desc')->firstOrFail();

				$project->tasks()->attach($theTask->id, array('project_id' => $id, 'status_id' => 1,'begin_date' => date("Y-m-d"), 'end_date' => null ));
			}
		}
		return Redirect::back()
		->with('status', Lang::get('task.storeSuccess'));
	}

}

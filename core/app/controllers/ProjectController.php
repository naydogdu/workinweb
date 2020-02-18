<?php
/*use Lib\Project\ActionProject as ActionProject;*/
use Lib\Gestion\ProjectGestion as ProjectGestion;
use Lib\Validation\ProjectCreateValidator as ProjectCreateValidator;

class ProjectController extends BaseController {

	protected $project;
	protected $project_gestion;
	protected $project_validation;

	public function __construct(
		ProjectGestion $project_gestion,
		ProjectCreateValidator $project_validation
		 /*ActionProject $action_project*/ )
	{
		//parent::__construct();
		/*$this->action_project = $action_project;*/
		$this->beforeFilter('user');
		$this->project_gestion = $project_gestion;
		$this->project_validation = $project_validation;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$id = Auth::id();
        return View::make('project.index', $this->project_gestion->index($id));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($generated_url)
	{
		$projects = User::find(Auth::id())->projects()->get(); // Début du filtre
		$rep = false;
		foreach ($projects as $oneProject) {
			if($oneProject->generated_url == $generated_url)
			{
				$rep = true;
			}
		}
		if($rep == false && helpers::getRoleById(Auth::id()) !=  'admin') {
			return Redirect::route('project.index'); // Fin du filtre
		} else {
			return View::make('project.show', $this->project_gestion->show($generated_url));
		}
		
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($generated_url)
	{
		$id = Auth::id();
		if (helpers::getPermission($id, $generated_url) == 1 || Auth::user()->role_id == 1) // Filtre administrateur ou chef de projet
        	return View::make('project.edit', $this->project_gestion->edit($generated_url));
        else 
        	return Redirect::back();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{	
		$id = Auth::id();
		return View::make('project.create', $this->project_gestion->create($id));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$id = Auth::id();
        if ($this->project_validation->fails())
        {
            return Redirect::back()
            ->withErrors($this->project_validation->errors())
            ->withInput();
        } else {
        	$idProject = $this->project_gestion->store($id);
        	if($idProject != false)
        	{
        		return Redirect::route('task.create', array('id' => $idProject))
        		->with('status', Lang::get('public.storeSuccess'));
        	} else {
        		return Redirect::back()
        		->with('date', Lang::get('public.errorDate'))
        		->withInput();
        	}
        } 
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($generated_url)
	{
		$project = Project::where('generated_url', '=', $generated_url)->firstOrFail();
		if($this->project_validation->fails())
		{
			return Redirect::back()
            ->withErrors($this->project_validation->errors())
            ->withInput();
		} else {
			if($this->project_gestion->update($generated_url))
			{
				return Redirect::route('project.edit', $generated_url)
	        	->with('status', Lang::get('public.editSuccess'));
			} else {
				return Redirect::back()
        		->with('date', Lang::get('public.errorDate'))
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
		$project = Project::withTrashed()->with('tasks', 'users')->find($id);
		
		if ($project->trashed()) {
			foreach ($project->tasks as $task) {
				$task_ = Task::withTrashed()->with('tickets')->findOrFail($task->id);
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
				$project->tasks()->detach($task_->id); // delete from the pivot task_project table
				$task_->forceDelete();
			}
			$project->tasks()->detach();
		    $project->forceDelete();
		} else {
			$project->delete();
		}

        return Redirect::route('project.index');
	}

	// Restoration d'un brouillon
	public function restore($id)
	{
		$project = Project::onlyTrashed()->find($id)->restore();
		return Redirect::route('project.index');
	}

}

<?php 

namespace Lib\Gestion;

use User;
use Task;
use Session;
use Input;
use Project;
use Profil;
use Request;
use Redirect;
use Permission;
use TypeProject;
use helpers;

class ProjectGestion implements ProjectGestionInterface {

	public function index($id)
	{
		$projects = User::find($id)->projects()->orderBy('end_date', 'desc')->get();
		$trashProjects = User::find($id)->projects()->orderBy('begin_date')->onlyTrashed()->get();
		foreach( $projects as $project ) {
			$project->timePourcentage = helpers::tasksDiff($project->tasks); // permet d'obtenir le nombre de jour entre le début et la fin d'un projet	
			$project->tasksStatus = helpers::getNumberTaskProjectChecked($project->id) . ' / ' . helpers::getNumberTaskProject($project->id);
		}
		return compact('projects', 'trashProjects');
	}

	public function show($generated_url)
	{
		$project = Project::withTrashed()->with('tasks', 'tickets')->where('generated_url', '=', $generated_url)->firstOrFail();
		$project->timePourcentage = helpers::tasksDiff($project->tasks); // permet d'obtenir le nombre de jour entre le début et la fin d'un projet
		return compact('project');
	}

	public function edit($generated_url)
	{
		$project = Project::with('users')->where('generated_url', '=', $generated_url)->firstOrFail();
		$userIn = array();
		foreach ($project->users as $p) {
			$userIn[] = $p->pivot->user_id;
		}
		$permission = Permission::all();
		$userNotIn = User::with('profil')
			->whereNotIn('users.id', $userIn)
			->where('society_id', '=', $project->society_id)
			->get(); // Permet d'obtenir toute les personnes non liées au projets
		return compact('project', 'permission', 'userNotIn');
	}

	public function create($id)
	{
		$profil = Profil::with('user', 'upload')
		->join('users', 'users.id', '=', 'profils.user_id')
		->where('user_id', '!=', $id)
		->where('society_id', '=', helpers::getSocietyId())->get();
		$permission = Permission::all();
		$typeProject = TypeProject::all();
		return compact('permission', 'profil', 'typeProject');
	}

		public function update($generated_url)
	{
		$projectUser = Project::with('users')->where('generated_url', '=', $generated_url)->firstOrFail();
		$project = Project::where('generated_url', '=', $generated_url)->firstOrFail();
		$project->name = Input::get('title');
		$project->description = Input::get('description');
		foreach ($projectUser->users as $p) { //Change the permission of the actual participant
			if (Input::has('permission'.$p->pivot->user_id)) {
				$user = User::findOrFail($p->pivot->user_id);
				$user->projects()->detach($project->id); //detach the old permission
				$permissionId = Input::get('permission'.$p->pivot->user_id);
				$user->projects()->attach($project->id, array('user_permission_id' => $permissionId)); // Attach the new permission
			}
		}
		if(Input::has('participant')){ // add new participant for the project	
			foreach (Input::get('participant') as $p) {
				if (Input::has('permission'.$p)) {
					$user = User::findOrFail($p);
					$permissionId = Input::get('permission'.$p);
					$user->projects()->attach($project->id, array('user_permission_id' => $permissionId));
				}
			}
		} 
		if(Input::has('delete')){ // If checkbox delete is true.
			foreach (Input::get('delete') as $d) {
					$user = User::findOrFail($d);
					$user->projects()->detach($project->id);
			}
		}
		if(Input::has('chief')){
			$userChief = User::findOrFail(Helpers::getChiefProjectId($project->id));
			$userChief->projects()->detach($project->id); // detach the old chief
			$userChief->projects()->attach($project->id, array('user_permission_id' => 2)); // Set at intervenant
			$user = User::findOrFail(Input::get('chief'));
			$user->projects()->detach($project->id);
			$user->projects()->attach($project->id, array('user_permission_id' => 1)); // Set at chef de projet
		}
		if(helpers::checkEndDateProject($project->id)) // If the project own a end_date
		{
			if(Input::has('noDate')) // if checkbox no date is check
			{
				$project->end_date = null;
			} else {
				if($this->checkDates()){ // si la date est ok
				$arrayBegin = array(Input::get('yearBegin'), Input::get('monthBegin'), Input::get('dayBegin'));
				$arrayEnd = array(Input::get('yearEnd'), Input::get('monthEnd'), Input::get('dayEnd'));
				$project->begin_date = implode('-', $arrayBegin);
				$project->end_date = implode('-', $arrayEnd);
				} else {
					return false;
				}
			}		
		} else { // if the project doesnt own a end_date
			if(Input::has('yesDate')) // and if the checkbox is check
			{
				if($this->checkDates()){ // si la date est ok
				$arrayBegin = array(Input::get('yearBegin'), Input::get('monthBegin'), Input::get('dayBegin'));
				$arrayEnd = array(Input::get('yearEnd'), Input::get('monthEnd'), Input::get('dayEnd'));
				$project->begin_date = implode('-', $arrayBegin);
				$project->end_date = implode('-', $arrayEnd);
				} else {
					return false;
				}
			}
		}
		$project->save();
		return true;
	}

	public function store($id) //Crée un projet
	{
		$project = new Project;	
		$generated_url = $id.str_random(rand(11,13));
		$project->generated_url = $generated_url;
		$project->name = Input::get('title');
		$project->description = Input::get('description');
		$project->type_project_id = Input::get('TypeProject'); // A faire Type project id
		$project->society_id = helpers::getSocietyId();
		if(Input::has('noDate'))
		{
			$project->begin_date = date('Y-m-d');
			$project->end_date = null;
		} 
		else
		{
			if($this->checkDates()){ // si la date est ok
				$arrayBegin = array(Input::get('yearBegin'), Input::get('monthBegin'), Input::get('dayBegin'));
				$arrayEnd = array(Input::get('yearEnd'), Input::get('monthEnd'), Input::get('dayEnd'));
				$project->begin_date = implode('-', $arrayBegin);
				$project->end_date = implode('-', $arrayEnd);
			} else {
				return false;
			}
		}
		$project->save();
		$theProject = Project::where('generated_url', '=', $generated_url)->firstOrFail();
		$user = User::find($id);
		$project->society_id = $user->society_id;
		$permissionCreator =Permission::find(1)->firstOrFail(); // Le créateur est automatiquement le chef de projet
		$user->projects()->attach($theProject->id, array('user_permission_id' => $permissionCreator->id));
		if(Input::has('participant'))
		{	
			foreach (Input::get('participant') as $p) {
				if (Input::has('permission'.$p)) {
					$users = User::findOrFail($p);
					$permissionId = Input::get('permission'.$p);
					$users->projects()->attach($theProject->id, array('user_permission_id' => $permissionId));
				}
			}
		}
		return $theProject->id;
	}

	public function checkDates()
	{
		if(Input::get('yearBegin') == Input::get('yearEnd')) {
			if (Input::get('monthBegin') == Input::get('monthEnd')) {
				if (Input::get('dayBegin') < Input::get('dayEnd')) {
					return true;
				}
			} elseif (Input::get('monthBegin') < Input::get('monthEnd')) {
				return true;
			}
		} elseif (Input::get('yearBegin') < Input::get('yearEnd')) {
			return true;
		}
		return false;
	}
}
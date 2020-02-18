<?php 

namespace Lib\Gestion;

use User;
use Session;
use Input;
use Project;
use TypeProject;
use helpers;
use Profil;
use Task;
Use StatusTask;

class TaskGestion implements TaskGestionInterface {

	

	public function edit($idTask, $idProject)
	{
		$profil = Profil::join('users', 'users.id', '=', 'profils.user_id')
		->join('projects_relations', 'projects_relations.user_id', '=', 'users.id')
		->where('society_id', '=', helpers::getSocietyId())
		->where('projects_relations.project_id', '=', $idProject)
		->get();
		$profil->task = Task::withTrashed()->with('status')->find($idTask);
		$profil->project = Project::find($idProject);
		$profil->status = StatusTask::orderBy('id')->get();
		return compact('profil');
	}

	public function update($idTask, $idProject)
	{
		$task = Task::find($idTask);
		$task->title = Input::get('title');
		$arrayBegin = array(Input::get('yearBegin'), Input::get('monthBegin'), Input::get('dayBegin'));
		$arrayEnd = array(Input::get('yearEnd'), Input::get('monthEnd'), Input::get('dayEnd'));
		if(helpers::checkEndDateTask($idTask)) // BEGINNING DATE GESTION
		{
			if(Input::has('noDate')) {
				$begin_date = date('Y-m-d');
				$end_date = null;
			} elseif(helpers::checkEndDateProject($idProject)) {// if the project has a end_date
				if($this->checkDates($idProject)){ // si la date est ok
					$begin_date = implode('-', $arrayBegin);
					$end_date = implode('-', $arrayEnd);
				} else {
					return false;
				}
			} else {
				$begin_date = implode('-', $arrayBegin);
				$end_date = implode('-', $arrayEnd);
				if(strtotime($begin_date) > strtotime($end_date)) {
					return false;
				}
			}
		} else {
			if(Input::has('yesDate')) {
				if(helpers::checkEndDateProject($idProject)) {
					if($this->checkDates($idProject)){ // si la date est ok
						$begin_date = implode('-', $arrayBegin);
						$end_date = implode('-', $arrayEnd);
					} else {
						return false;
					}
				} else {
					$begin_date = implode('-', $arrayBegin);
					$end_date = implode('-', $arrayEnd);
					if(strtotime($begin_date) > strtotime($end_date)) {
						return false;
					}
				}
			} else {
				$task_date = Task::find($idTask)->projects()->firstOrFail();
				$begin_date = $task_date->pivot->begin_date;
				$end_date = null;
			}
		} // END DATE GESTION
		$task->save();
		$project = Project::find($idProject);
		$project->tasks()->detach($task->id);
		$project->tasks()->attach($task->id, array('project_id' => $idProject, 'status_id' => Input::get('status_id'),'begin_date' => $begin_date, 'end_date' => $end_date));
		$taskUser = Task::find($idTask) // permet d'obtenir les utilisateurs sur une tache d'un projet
		->join('task_project', 'tasks.id', '=', 'task_project.task_id')
		->join('task_user', 'tasks.id', '=', 'task_user.task_id')
		->where('task_project.project_id', '=', $idProject)
		->where('task_user.task_id', '=', $idTask)
		->get();
		if(Input::has('participant')){ // add new participant for the project
			foreach ($taskUser as $user) {
				$rep = false;
				foreach (Input::get('participant') as $p) {
					if($user->user_id == $p) {
						$rep = true;
					}
				}
				if($rep == false)
				{
					$user2 = User::findOrFail($user->user_id);
					$user2->tasks()->detach($task->id);
				}
			}
			foreach (Input::get('participant') as $p) {
				$rep = true;
				foreach ($taskUser as $user) {
					if($user->user_id == $p) {
						$rep = false;
					}
				}
				if ($rep == true)
				{
					$user = User::findOrFail($p);
					$user->tasks()->attach($task->id, array('user_id' => $p));
				}
			}
		}
		return true;
	}

	public function create($idProject)
	{
		$profil = Profil::join('users', 'users.id', '=', 'profils.user_id')
		->join('projects_relations', 'projects_relations.user_id', '=', 'users.id')
		->where('society_id', '=', helpers::getSocietyId())
		->where('projects_relations.project_id', '=', $idProject)
		->get();
		$profil->project = Project::find($idProject);
		$profil->tasksGlobale = TypeProject::find($profil->project->type_project_id)->tasksPublic()->get();
		return compact('profil');
	}

	public function store($idProject) //Crée une tâche
	{
		$task = new Task;
		$task->title = Input::get('title');
		if(Input::has('noDate'))
		{
			$begin_date = date("Y-m-d");
			$end_date = null;
		} else {
			if(Input::has('dayBegin'))
			{
				if($this->checkDates($idProject)){ // si la date est ok
					$arrayBegin = array(Input::get('yearBegin'), Input::get('monthBegin'), Input::get('dayBegin'));
					$arrayEnd = array(Input::get('yearEnd'), Input::get('monthEnd'), Input::get('dayEnd'));
					$begin_date = implode('-', $arrayBegin);
					$end_date = implode('-', $arrayEnd);
				} else {
					return false;
				}
			} else {
				$arrayBegin = array(Input::get('yearBegin'), Input::get('monthBegin'), Input::get('dayBegin_2'));
				$arrayEnd = array(Input::get('yearEnd'), Input::get('monthEnd'), Input::get('dayEnd'));
				$begin_date_toTime = strtotime(implode('-', $arrayBegin)); // date for strtotime
				$end_date_toTime = strtotime(implode('-', $arrayEnd)); 
				$begin_date = implode('-', $arrayBegin); //date for database
				$end_date = implode('-', $arrayEnd);	
				if($begin_date_toTime > $end_date_toTime)
				{
					return false;
				}
			}
		}
		$task->save();
		$theTask = Task::where('title', '=', Input::get('title'))->orderBy('id', 'desc')->first();
		if(Input::has('participant')){ // add new participant for the project	
			foreach (Input::get('participant') as $p) {
				$user = User::findOrFail($p);
				$user->tasks()->attach($theTask->id, array('user_id' => $p));
			}
		}
		$project = Project::findOrFail($idProject);
		$project->tasks()->attach($theTask->id, array('project_id' => $idProject,'status_id' => 1,'begin_date' => $begin_date, 'end_date' => $end_date));
		return true;
	}

	public function checkDates($idProject) // check les champs dates
	{
		$project = Project::find($idProject);
		$arrayBegin = array(Input::get('yearBegin'), Input::get('monthBegin'), Input::get('dayBegin'));
		$arrayEnd = array(Input::get('yearEnd'), Input::get('monthEnd'), Input::get('dayEnd'));
		$begin_date = strtotime(implode('-', $arrayBegin));
		$end_date = strtotime(implode('-', $arrayEnd));
		if ($begin_date < strtotime($project->begin_date) || $begin_date > strtotime($project->end_date)) // if begin_date task is inferior or superior of the project date, return false
		{
			return false;
		} 
		elseif ($end_date < strtotime($project->begin_date) )// if end_date task is inferior of begin_date project, return false
		{
			return false;
		}
		elseif($begin_date > $end_date)
		{
			return false;
		} else {
			return true;
		}
	}
}

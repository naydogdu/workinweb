<?php 

namespace Lib\Gestion;

use User;
use Session;
use Input;
use helpers;
use Task;
use StatusTask;
use TasksPublic;
use TypeProject;

class TaskPublicAdminGestion implements TaskPublicAdminGestionInterface {

	

	public function index()
	{
		$typeProject = TypeProject::with('tasksPublic')->get();
		return compact('typeProject');
	}

	public function update($idTask)
	{
		$tasksPublic = TasksPublic::findOrFail($idTask);
		$tasksPublic->title = Input::get('title');
		$tasksPublic->save();
	}

	public function create()
	{
		$listTypesProjects = TypeProject::lists('name', 'id');
		return compact('listTypesProjects');
	}

	public function store()
	{
		$task = new TasksPublic;
		$task->title = Input::get('title');
		$task->public_type = Input::get('typeProject');
		$task->save();
	}

}
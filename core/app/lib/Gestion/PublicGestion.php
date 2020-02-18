<?php 

namespace Lib\Gestion;

use User;
use Task;
use Session;
use Input;
use Project;
use Redirect;
use helpers;

class PublicGestion implements PublicGestionInterface {

	public function index($id)
	{
		$tasks = User::find($id)->tasks()->get();
		$tasksTrashed = User::find($id)->tasks()->onlyTrashed()->get();
		$projects = User::find($id)->projects()->orderBy('end_date', 'desc')->get();
		foreach( $projects as $project ) {
			$project->timePourcentage = helpers::tasksDiff($project->tasks); // permet d'obtenir le nombre de jour entre le début et la fin d'un projet
			$project->tasksStatus = helpers::getNumberTaskProjectChecked($project->id) . ' / ' . helpers::getNumberTaskProject($project->id);
		}
		return compact('tasks', 'tasksTrashed', 'projects');
	}
}
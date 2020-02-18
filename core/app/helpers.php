<?php
class Helpers {
	public static  function Dbug() {
		// $dbug = "path to app/directory : " .app_path(); 
		// $dbug .= "<br> path to base : ".base_path();
		// $dbug .= "<br> path to public : ".public_path();
		/*$dbug = "<br> BaseName : ".class_basename(Request::path());
		$dbug .= "<br>request method : " . Request::method();
		$dbug .= "<br>request url : ". Request::url();
		$dbug .= "<br>Segment : ". Request::segment(1);
		$dbug .= "<br>Token : ". csrf_token();
		$dbug .= "<br>action : ". Route::currentRouteAction();
        $dbug .= "<br>route name : ". Route::currentRouteName();
        $dbug .= "<br> Id Société : ". helpers::getSocietyId();
        $dbug .= "<br> Role : ". helpers::getRoleById(Auth::id());
        $dbug .= "<br> Id user : ". Auth::id();*/
		// if (Request::secure())
		// {
		//     $dbug .= "<br>secure : yes";
		// } else {
		// 	$dbug .= "<br>secure : no";
		// }
		//return $dbug .= "<br>path : ". Request::path();
	}
	public static function getAvatar($userId=null, $classes='dis-ib round hw40 divbg') {
		if( null == $userId ) : 
			$user = Profil::findOrFail(Auth::id()); 
		else :
			$user = Profil::findOrFail($userId); 
		endif;
		$ava = Upload::find($user->avatar_id);
		$avatarDefault = url('img/avatar/default.jpg'); // Avatar par défaut
		if($ava) : 
			return '<div class="'. $classes .'" style="background-image: url(' . $ava->url . ');"></div>'; 
		else : 
			return '<div class="'. $classes .'" style="background-image: url('. $avatarDefault .');"></div>';
		endif;
	}

	/*public static function get_default_avatar() {
		return $avatarDefault = url('img/avatar/default.jpg');
	}*/

	public static function getRole($mail)
	{
		$role = User::where('email', '=', $mail)->firstOrFail()->role;
		return $role->role;
	}
	public static function getRoleById($id)
	{
		$role = User::findOrFail($id)->role;
		return $role->role;
	}
	
	public static function getAvatarUrl($id) {
		$user = Profil::find($id);
		$ava = Upload::find($user->avatar_id);
		if($ava) : return $ava->url; endif;
	}
	public static function getProfilInfo($id) {
		$user = Profil::find($id);
		return $user; 
	}
	// return url of the project for a task user.
	public static function getTaskProject($idUser, $idTask)
	{
		$project = Task::join('task_user', 'task_user.task_id', '=', 'tasks.id')
				->join('task_project', 'task_project.task_id', '=', 'tasks.id')
				->join('projects', 'task_project.project_id', '=', 'projects.id')
				->where('task_user.user_id', '=', $idUser)
				->where('task_user.task_id', '=', $idTask)
				->select('projects.name')
				->first();
		if( !empty($project) )
			return $project->name;
	}
	// return url of the project for a task user.
	public static function getUrlProject($idUser, $idTask)
	{
		$project = Task::join('task_user', 'task_user.task_id', '=', 'tasks.id')
				->join('task_project', 'task_project.task_id', '=', 'tasks.id')
				->join('projects', 'task_project.project_id', '=', 'projects.id')
				->where('task_user.user_id', '=', $idUser)
				->where('task_user.task_id', '=', $idTask)
				->select('projects.generated_url')
				->first();
		/*if($project->generated_url == null) {
		 	return null;
		}*/
		if( !empty($project) )
			return $project->generated_url;
		//return $project->generated_url;
	}
	
	public static function getUserEmail($id) {
		$user = User::find($id);
		return $user->email;
	}
	// check if user has last_name or first_name, else false
	public static function checkPublicName($id) {
		$user = Profil::find($id);
		if( $user->last_name || $user->first_name) :
			return $user->last_name . ' ' . $user->first_name;
		else : 
			return helpers::getUserEmail($user->user_id); 
		endif;
	}

	// Check if the user own an avatar_id in the database
	// True if yes, or false if not.
	public static function checkAvatarId($id) {
		$user = Profil::find($id);
		$ava = Upload::find($user->avatar_id);
		if($ava) : return $rep = true; else : return $rep = false; endif; 
	}

	// get the permission of a user on a project
	public static function getPermission($id, $url){
		$rep = Project::withTrashed()->where('generated_url', '=', $url)
				->with('users')
				->firstOrFail()->users()
				->where('user_id', '=', $id)
				->first();
		if ($rep !== null) : return $rep->pivot->user_permission_id; //put ->permission_name for the name
		else : return null; endif;
	}

	// Return the id of the chief project
	// $id = id project
	public static function getChiefProjectId($id){
		$user = Project::findOrFail($id)->users()->where('projects_relations.user_permission_id', '=', 1)->firstOrFail();
		return $user->pivot->user_id;
	}

	public static function tasksDiff($obj){ // Permet d'obtenir la différence entre la date de début et de fin d'un projet ou autre.
		$ok = 0;
		$i = 0;
		
		foreach( $obj as $item ) {
			$i++;
			if( $item->pivot->status_id == 5)
				$ok++;
		}
	    if( $i > 0)
			$value = (int) $ok / (int) $i * (int) 100;
	    else
			$value = 0;
		return round($value); //$retour;
	}
	
	public static function dateDiff($date1, $date2){ // Permet d'obtenir la différence entre la date de début et de fin d'un projet ou autre.
		if($date1 != time()) { // dans le cas ou une des variables est time() qui est déjà sous forme timestamp
			$date1 = strtotime($date1);			
		}
		if($date2 != time()) {
			$date2 = strtotime($date2);			
		}

	    $diff = abs($date1 - $date2); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
	    $retour = array();
	 
	    $tmp = $diff;
	    $retour['second'] = $tmp % 60;
	 
	    $tmp = floor( ($tmp - $retour['second']) /60 );
	    $retour['minute'] = $tmp % 60;
	 
	    $tmp = floor( ($tmp - $retour['minute'])/60 );
	    $retour['hour'] = $tmp % 24;
	 
	    $tmp = floor( ($tmp - $retour['hour'])  /24 );
	    $day = $tmp; //$retour['day'] = $tmp;
	     
	    return  $day; //$retour;
	}

	public static function pourcentageDate($durationProject, $timeLeft) {
		if($durationProject == 0) {
			return 0;
		} else {
			$nbDayActual = $durationProject - $timeLeft;
			$pourcentage = round($nbDayActual / $durationProject * 100);
			if($pourcentage > 0) : return $pourcentage; else : return 0; endif;
		}
	}

	public static function getSocietyId() {
		$user = User::select('society_id')->findOrFail(Auth::id());
		return $user->society_id;
	}

	// param : society id and return the society
	public static function getSocietyName($id) {
		$society = Society::findOrFail($id);
		return $society->name;
	}

	// check if the user is a owner of one society
	// param id user
	public static function checkIfOwnerSociety($id)
	{
		$society = Society::where('creator_id', '=', $id)->first();
		if ($society !== null) : return true; else: return false; endif;
	}

	//get owner society
	public static function getOwnerSociety($id)
	{
		$user = Society::find($id)->firstOrFail()->user;
		return $user;
	}

	public static function getStatusTask($id, $icon=null) {
		$status = DB::table('status_tasks')->where('id', '=', $id)->select('id','name')->first();
		if( $icon != null) :
			switch ($status->id) {				
				case 2 : $statusIcon = 'fa-circle';	break;
				case 3 : $statusIcon = 'fa-question-circle'; break;
				case 4 : $statusIcon = 'fa-check-circle-o';	break;
				case 5 : $statusIcon = 'fa-check-circle'; break;
				case 6 : $statusIcon = 'fa-exclamation-circle';	break;
				default : $statusIcon = 'fa-circle-thin';			
			}
			return '<span class="'. $status->id .'"><i class="fa '. $statusIcon .'"></i></span>';
		else: 
			return 'status-'.$status->id;
		endif;
	}

	// param : user id
	public static function getProjectsUser($id)
	{
		return $projects = User::findOrFail($id)->projects()->get();
	}

	// param : user id
	public static function getTasksUserWithoutTrash($id)
	{
		return $tasks = User::findOrFail($id)->tasks()->get();
	}

	// param : user id
	public static function getTasksUserOnlyTrash($id)
	{
		return $tasks = User::findOrFail($id)->tasks()->onlyTrashed()->get();
	}

	// Check if a user has task
	// param : user id
	public static function checkTaskUser($id)
	{
		$task = User::find($id)->tasks()->withTrashed()->get();
		if(count($task) === 0) : return false; else : return true; endif;
	}

	public static function getTypeProject($idType)
	{
		$type = TypeProject::find($idType);
		return $type->name;
	}

	// Retourne le nombre de personnes sur un projet
	public static function getNumberPeopleProject($idProject)
	{
		return $project = Project::withTrashed()->find($idProject)->users()->count();
	}

	public static function getNumberTaskProject($idProject)
	{
		return $task = Project::withTrashed()->find($idProject)->nbTasks()->count();
	}
	
	public static function getNumberTaskProjectChecked($idProject)
	{
		return $task = Project::withTrashed()->find($idProject)->nbTasks()->where('status_id', '=', 5)->count();
	}
	// retourne  le nombre de personnes sur une tâche
	public static function getNumberPeopleTask($idTask)
	{
		return $task = Task::find($idTask)->users()->count();
	}

	public static function getNumberPeopleSociety($idSociety)
	{
		return $task = Society::find($idSociety)->users()->count();
	}

	//check if the project has a endDate
	public static function checkEndDateProject($idProject)
	{
		$project = Project::withTrashed()->find($idProject);
		if($project->end_date == null) : return false; else : return true; endif;
	}

	//check if the task has a endDate
	public static function checkEndDateTask($idTask)
	{
		$task = Task::withTrashed()->find($idTask)->projects()->withTrashed()->firstOrFail();
		if($task->pivot->end_date == null) : return false; else : return true; endif;
	}

	//Permet de savoir si la tâche existe déjà sur le projet
	public static function checkIfTaskExistOnProject($idTask, $idProject)
	{
		$task = Task::find($idTask)->projects()->find($idProject);
		if($task == null) : return true; else: return false; endif;
	}

	// définit si oui ou non, il y a encore des tâches globale pour ce projet
	public static function checkIfWeCanAddTaskGlobal($idProject)
	{
		$project = Project::findOrFail($idProject);
		$tasks = TypeProject::find($project->type_project_id)->tasks()->get();
		foreach ($tasks as $task) {
			$theProject = Task::find($task->id)->projects()->first();
			if(!isset($theProject->id)) : return true; endif;
		}
		return false;
	}

	/* tickets */
	public static function getTicketForm($ticketableId, $ticketableType)
	{
		$before = '<div class="form-group pdt0">';
		$after = '</div>';
		
		$form  = Form::open(array('route' => array( $ticketableType .'.tickets.store', $ticketableId), 'method' => 'post', 'class' => 'form-horizontal'));
		$form .= $before .'<textarea class="dis-b w100 mrg0 mb12" name="content" placeholder="'. trans('public.ticketCreateContent') .'" id="ticket-content-'. $ticketableType .'-'. $ticketableId .'"></textarea> ';
		$form .= '<div class="tar"><input type="submit" class="btn" value="'. trans('public.sendTicket') .'"></div>'. $after;
		$form .= Form::close();
		
		return $form;
	}	
}
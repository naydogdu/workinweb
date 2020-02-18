<?php 

namespace Lib\Gestion;

use User;
use Role;
use Project;
use Input;
use Hash;
use Profil;
use Upload;
use helpers;

// A modificer au fur et à mesure
class ProfilGestion implements ProfilGestionInterface {


	public function index($n)
	{
		$users = User::paginate($n);
		return compact('users');
	}

	public function show($id)
	{
		$profil = Profil::with('upload')->where('user_id', '=', $id)->firstOrFail();
		$tasks = User::find($id)->tasks()->get();
		$projects = User::find($id)->projects()->orderBy('end_date', 'desc')->get();
		foreach( $projects as $project ) {
			$project->durationProject = helpers::dateDiff($project->begin_date, $project->end_date); // permet d'obtenir le nombre de jour entre le début et la fin d'un projet
			$project->timeLeft = helpers::dateDiff(time(), $project->end_date);
			$project->timePourcentage = helpers::pourcentageDate($project->durationProject ,$project->timeLeft);	
			$project->tasksStatus = helpers::getNumberTaskProjectChecked($project->id) . ' / ' . helpers::getNumberTaskProject($project->id);
		}
		return compact('profil', 'tasks', 'projects');
	}

	// For the view edit profil, we need to explode the birthday
	public function edit($id)
	{
		$profil = Profil::with('uploads', 'user')->where('user_id', '=', $id)->firstOrFail(); // Array user_profil + uploads (avatar)
		if($profil->birthday != null) { // gestion birthday
			$birthdayExplodes = explode('-', $profil->birthday);
			$profil['year'] = $birthdayExplodes[0];
			$profil['month'] = $birthdayExplodes[1];
			$profil['day'] = $birthdayExplodes[2];
		}
		return compact('profil');
	}


	// Update the profil
	public function update($id)
	{	
		if (Input::has('avatar_id'))
		{
			$profil = Profil::find($id);
			$profil->avatar_id = Input::get('avatar_id');
			$profil->save();

		} else {
			$profil = Profil::find($id);
			if(Input::has('last_name')) : $profil->last_name = Input::get('last_name'); else : $profil->last_name = null; endif;
			if(Input::has('first_name')) : $profil->first_name = Input::get('first_name'); else : $profil->first_name = null; endif;
			if(Input::has('gender')) : $profil->gender = Input::get('gender'); else : $profil->gender = null; endif;
			if(Input::has('occupation')) : $profil->occupation = Input::get('occupation'); else : $profil->occupation = null; endif;
			$yearAcutal = date("Y");
			if(Input::get('year') != $yearAcutal)
			{
				$array = array(Input::get('year'), Input::get('month'), Input::get('day'));
				$profil->birthday = implode('-', $array);
			} else {
				$profil->birthday = null;
			}
			
			if(Input::hasFile('avatar'))
			{
				if (Input::file('avatar')->isValid())
				{
					$avatar = Input::file('avatar'); 
					$name = str_random(rand(15,25)); // Create name size
					$upload = Upload::create(array(
					'url' 	=> url("img/avatar").'/'.$name.'.'.$avatar->getClientOriginalExtension(), // Url du chemin ou sera sauvé l'image
					'name'	=> $name.'.'.$avatar->getClientOriginalExtension(),
					'size'	=> $avatar->getClientSize(),
					'type'	=> $avatar->getMimeType()
					));
					$profil->uploads()->save($upload);
					$id_upload = Upload::where('name', '=', $name.'.'.$avatar->getClientOriginalExtension())->firstOrFail();
					$profil->avatar_id = $id_upload['id'];			
					try {
 
						$file = Input::file('avatar')->move(public_path().'/img/avatar', $name.'.'.$avatar->getClientOriginalExtension()); // Chemin de sauvegarde de l'image
					 
					} catch(Exception $e) {
					 
						// Handle your error here.
						$e->getMessage();
					}
					
				}
			} 
			$profil->save();
		}
	}

	public function destroy($id, $idUser)
	{	
		$profil = Profil::where('user_id', '=', $idUser)->firstOrFail(); // On récupère le profil user
		$upload = Profil::where('user_id', '=', $idUser)->firstOrFail()->uploads; // On récupère la liste d'avatar pour gérer les nouveaux id_avatar
		if($id == $profil->avatar_id) // si l'id de l'image et le même que l'avatar sélectionné, on rentre dans la condition
		{	
			$count = 0;
			foreach ($upload as $a) {
				$count++;
			}
			if ($count > 1) // Si il y a plus d'un avatar (donc qu'il en restera encore 1 après la suppression)
			{	
				// Si le premier avatar du tableau est supprimé alors qu'il était sélectionné comme avatar, et qu'il en reste au moins 2
				// on passe au second avatar.
				if ($upload['0']->id == $id) 
				{
					$profil->avatar_id = $upload['1']->id;
				} else {
					$profil->avatar_id = $upload['0']->id;	
				}
			} else { // Si il ne reste plus d'avatar après la suppression, on initialise avatar_id à nul.
				$profil->avatar_id = null;
			}
			$profil->save();
		}

		Upload::find($id)->Delete();
	}
}
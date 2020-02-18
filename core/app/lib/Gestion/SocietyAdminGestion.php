<?php 

namespace Lib\Gestion;

use User;
use Role;
use Input;
use Hash;
use Profil;
use Society;
use Project;
use DB;

class SocietyAdminGestion implements SocietyAdminGestionInterface {


	public function index($n)
	{
		$societys = Society::paginate($n);
		return compact('societys');
	}

	public function show($id)
	{
		$society = Society::with('users')->find($id);
		return compact('society');
	}

	public function create()
	{
		$users = User::where('society_id', '=', null)->lists('email', 'id');
		return compact('users');
	}

	public function edit($id)
	{
		$society = Society::with('users')->find($id);
		$usersList = User::where('society_id', '=', $id)->lists('email', 'id');
		$usersNoSociety = User::where('society_id', '=', null)->get();
		return compact('society', 'usersList', 'usersNoSociety');
	}

	public function update($id)
	{
		if(Input::has('nameSociety'))
		{
			$society = Society::findOrFail($id);
			$society->name = Input::get('nameSociety');
			$society->siret = Input::get('siret');
			$society->creator_id = Input::get('creator');
			$society->save();
		}
		if(Input::has('participantDelete')){ // delete new participant for the project	
			foreach (Input::get('participantDelete') as $p) {
				$user = User::findOrFail($p);
				$user->society_id = null;
				$user->save();
			}
		} 
		if(Input::has('participant')){ // add new participant for the project	
			foreach (Input::get('participant') as $p) {
				$user = User::findOrFail($p);
				$user->society_id = $id;
				$user->save();
			}
		}
		if(Input::has('email')) 
		{
			if(User::where('email','=', Input::get('email'))->first() !== null)
			{
				$user = User::where('email','=', Input::get('email'))->firstOrFail();
				$user->society_id = $id;
				$user->save();
			} else {
				return false; //renvoie true si il faut créer l'utilisateur
			}
		}
		return true;
	}

	public function store()
	{
		$society = new Society;
		$user = User::find(Input::get('creator'));
		$society->name = Input::get('nameSociety');
		$society->siret = Input::get('siret');
		$society->creator_id = Input::get('creator');
		$society->save();
		$theSociety = Society::where('siret', '=', Input::get('siret'))->firstOrFail();
		$user->society_id = $theSociety->id;
		$user->save();
	}

	public function destroy($id)
	{
		$society = Society::with('users')->find($id);
		foreach ($society->users as $user) {
			$theUser = User::findOrFail($user->id);
			$theUser->society_id = null;
			$theUser->save();
		}
		$society->delete();
	}

}
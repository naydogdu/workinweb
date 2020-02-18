<?php 

namespace Lib\Gestion;

use User;
use Role;
use Input;
use Hash;
use Profil;
use Society;

class UserGestion implements UserGestionInterface {

    private function save($user)
	{
		if(Input::has('email'))
		{
			$user->email = Input::get('email');
		}
		if(Input::has('email_1'))
		{
			$user->email = Input::get('email_1');
		}
		$user->save();
	}

	public function index($n)
	{
		$users = User::where('society_id', '=', null)->get();
		$society = Society::with('users')->orderBy('name')->paginate($n);
		return compact('society', 'users');
	}

	public function store() //Crée un utilisateur
	{
		$user = new User;		
		$user->password = Hash::make(Input::get('password'));
		$user->role_id = 2; // set to role user
		$this->save($user);
	}
	public function store_($pswd) //Crée un utilisateur qui n'a pas rentré de mot de passe
	{
		$user = new User;
		$user->password = Hash::make($pswd);
		$user->role_id = 2; // set to role user
		$this->save($user);
	}
	public function storeInvitation($pswd, $id) //Crée un utilisateur à partir de l'invitation
	{
		$user = new User;
		$user->password = Hash::make($pswd);
		$user->role_id = 2; // set to role user
		$user->society_id = $id;
		$this->save($user);
	}

	public function show($id)
	{
		$profil = Profil::with('upload', 'user')->where('user_id', '=', $id)->firstOrFail();
		return compact('profil');
	}

	public function edit($id)
	{
		$user = User::with('profil', 'role')->where('id', '=', $id)->firstOrFail();
		$roles = Role::all();
		$society = Society::lists('name', 'id');
		return compact('user', 'roles', 'society');
	}

	public function update($id)
	{
		$user = User::find($id);
		if(Input::has('role_id')) {
			$user->role_id = Input::get('role_id');
		}
		if(Input::has('password')) {
			$user->password = Hash::make(Input::get('password'));
		}
		if(Input::has('password_1')) {
			$user->password = Hash::make(Input::get('password_1'));
		}
		if(Input::has('society')) {
			if(Input::get('society') == 'null') {
				$user->society_id = null;
			} else {
				$user->society_id = Input::get('society');
			}
		}
		$this->save($user);
	}

	public function destroy($id)
	{
		User::find($id)->delete();
	}

	public function getRole($mail)
	{
		return $role = User::where('email', '=', $mail)->firstOrFail()->role;
	}

}
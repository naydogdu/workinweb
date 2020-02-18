<?php 

use Lib\Validation\ProfilUpdateValidator as ProfilUpdateValidator;
use Lib\Gestion\ProfilGestion as ProfilGestion; 

class ProfilController extends BaseController {

	protected $update_validation;
	protected $profil_gestion;

	public function __construct(
		ProfilUpdateValidator $update_validation,
		ProfilGestion $profil_gestion
	) {
		$this->beforeFilter('user');
		$this->update_validation = $update_validation;
		$this->profil_gestion = $profil_gestion;
	}

	public function show($id)
	{
		return View::make('public.profil.show', $this->profil_gestion->show($id));
	}


	// View edit profil
	public function edit($id)
	{
		$idUser = Auth::id();
		if('admin' != helpers::getRoleById($idUser))
			$id = $idUser;
		return View::make('public.profil.edit', $this->profil_gestion->edit($id));
	}

	// update the profil
	public function update($id)
	{	
		if ($this->update_validation->fails($id)) {
		  return Redirect::route('profil.edit', array($id))
		  ->withInput()
		  ->withErrors($this->update_validation->errors());
		} else {
			$this->profil_gestion->update($id);
			return Redirect::route('profil.edit', array($id))
			->with('status',Lang::get('profil.updated'));
		}
	}

	// Détruit un avatar
	public function destroy($id)
	{	
		$idUser = Auth::id();
		$this->profil_gestion->destroy($id, $idUser);
		return Redirect::back()
		->with('status',Lang::get('profil.deleted'));
	}
}
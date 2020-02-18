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

class ProjectAdminGestion implements ProjectAdminGestionInterface {


	public function index($n)
	{
		$societys = Society::with('projects') // retourne uniquement les sociétés avec un projets
		->select(array('societys.id', 'siret', 'creator_id', 'societys.name', DB::raw('COUNT(ww_projects.id) as count') ))
		->join('projects', 'projects.society_id', '=', 'societys.id')
		->orderBy('societys.name')
		->groupBy('societys.name')
		->paginate($n);
		return compact('societys');
	}

}
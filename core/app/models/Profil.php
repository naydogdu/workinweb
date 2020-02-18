<?php 

class Profil extends Eloquent {

	protected $table = 'profils';

	public $timestamps = true;


	public function user() {
		return $this->belongsTo('User', 'id');
	}

	public function uploads() 
	{
		return $this->belongsToMany('Upload', 'upload_profil', 'profil_id', 'upload_id');
	}

	public function upload()
	{
		return $this->hasOne('Upload', 'id', 'avatar_id');
	}

	// public function permission()
	// {
	// 	return $this->belongsTo('User', 'id')
	// 		->join('projects_relations', 'user_id', '=', 'users.id')
	// 		->join('users_permissions', 'users_permissions.id','=', 'projects_relations.user_permission_id')
	// 		->select('users_permissions.name as pivot_permission_name', 'users_permissions.permission as pivot_permission_slug');
	// }

}
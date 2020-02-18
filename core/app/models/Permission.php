<?php

class Permission extends Eloquent /*implements Lib\Project\ActionProjectInterface*/ {

	protected $table = 'users_permissions';
	
	public $timestamps = false;
	
	public function users() {
	
		return $this->belongsToMany('User', 'projects_relations', 'project_id', 'user_id')->withPivot('user_permission_id');
	}
}
<?php

class Society extends Eloquent {

	protected $table = 'societys';
	
	public function users() {	
		return $this->hasMany('User');	 
	}

	public function user() {
		return $this->hasOne('User', 'id', 'creator_id');
	}

	public function projects() {
		return $this->hasMany('Project')->orderBy('type_project_id');
	}
}
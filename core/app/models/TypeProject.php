<?php

class TypeProject extends Eloquent {

	protected $table = 'types_projects';

	public $timestamps = false;

	public function project()
	{
		return $this->hasMany('Project', 'type_project_id');
	}

	public function tasksPublic()
	{
		return $this->hasMany('TasksPublic', 'public_type');
	}

}
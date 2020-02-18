<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $table = 'users';

	protected $hidden = array('password', 'remember_token');

	public function society()
    {
        return $this->belongsTo('Society');
    }

	public function role()
    {
        return $this->belongsTo('Role', 'role_id', 'id');
    }

    public function profil()
    {
    	return $this->hasOne('Profil', 'user_id');
    }
 	public function tasks()
    {
        return $this->belongsToMany('Task', 'task_user');
    }	 
	
	public function projects() 
	{
		return $this->belongsToMany('Project' , 'projects_relations')->withPivot('user_permission_id');
	}

	public function permissions() 
	{
		//return $this->morphedByMany('Permission', 'projects_relations','project_id', 'user_id', 'user_permission_id');
		return $this->belongsToMany('Permission', 'projects_relations', 'user_id', 'user_permission_id');
	}
}

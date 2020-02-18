<?php 

class Role extends Eloquent {
	protected $table = 'roles';
	public $timestamps = false;

	public function user()
    {
        return $this->hasMany('User', 'role_id');
    }

}
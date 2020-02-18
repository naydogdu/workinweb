<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Project extends Eloquent /*implements Lib\Project\ActionProjectInterface*/ {

	protected $table = 'projects';

	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	public $timestamps = false;
	
	public function users() {
	
		return $this->belongsToMany('User', 'projects_relations')->withPivot('user_permission_id')
			->join('users_permissions', 'user_permission_id', '=', 'users_permissions.id')
			->select('users_permissions.name as pivot_permission_name', 'users.email as pivot_user_email', 'users.id as pivot_user_id');
	}
	
	public function typeProject()
    {
        return $this->belongsTo('TypeProject', 'type_project_id', 'id');
    }

    public function tasks()
    {
        return $this->belongsToMany('Task', 'task_project')->withPivot('status_id', 'begin_date', 'end_date')
        ->with('users', 'tickets')
        ->withTrashed()
        ->orderBy('tasks.id')
        ->groupBy('tasks.id');
    }
    
    public function nbTasks()
    {
    	return $this->belongsToMany('Task', 'task_project');
    }

	public function tickets()
    {
        return $this->morphMany('Ticket', 'ticketable');
    }

    public function society()
    {
    	return $this->hasOne('Society', 'society_id');
    }
}
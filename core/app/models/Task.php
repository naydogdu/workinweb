<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Task extends Eloquent {

	protected $table = 'tasks';

	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	public $timestamps = false;
	
	public function users()
    {
        return $this->belongsToMany('User', 'task_user');
    }

    public function status()
    {
    	return $this->belongsToMany('StatusTask', 'task_project', null ,'status_id');
    }
	
	public function projects()
    {
        return $this->belongsToMany('Project', 'task_project')->withPivot('begin_date', 'end_date');
    }
	
	public function tickets()
    {
        return $this->morphMany('Ticket', 'ticketable');
    }

    public function typeProject()
    {
        return $this->belongsTo('TypeProject', 'public_type');
    }
}
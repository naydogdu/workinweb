<?php 

class StatusTask extends Eloquent {
	protected $table = 'status_tasks';
	public $timestamps = false;

	public function tasks()
    {
        return $this->belongsToMany('Task', 'task_project', 'task_id');
    }

}
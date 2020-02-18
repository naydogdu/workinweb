<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TasksPublic extends Eloquent {

	public $timestamps = false;

	protected $table = 'tasks_public';

	public function typeProject()
    {
        return $this->belongsTo('TypeProject', 'public_type');
    }

}
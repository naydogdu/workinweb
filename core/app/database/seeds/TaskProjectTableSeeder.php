<?php

class TaskProjectTableSeeder extends Seeder {
	public function run()
	{
		DB::table('task_project')->insert(array(
			'id' 			=> 1,
			'task_id' 		=> 1,
			'project_id'	=> 2,
			'status_id'		=> 1,
			'begin_date'	=> '2015-02-15',
			'end_date'		=> '2015-02-18'
		));
		DB::table('task_project')->insert(array(
			'id' 			=> 2,
			'task_id' 		=> 2,
			'project_id'	=> 2,
			'status_id'		=> 2,
			'begin_date'	=> '2015-02-19',
			'end_date'		=> '2015-02-20'
		));
		DB::table('task_project')->insert(array(
			'id' 			=> 3,
			'task_id' 		=> 3,
			'project_id'	=> 2,
			'status_id'		=> 1,
			'begin_date'	=> '2015-02-21',
			'end_date'		=> '2015-02-24'
		));
	
	}
}
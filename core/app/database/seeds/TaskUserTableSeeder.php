<?php

class TaskUserTableSeeder extends Seeder {
	public function run()
	{
		DB::table('task_user')->insert(array(
			'id' 	=> 1,
			'task_id' => 1,
			'user_id' => 1
		));
		DB::table('task_user')->insert(array(
			'id' 	=> 2,
			'task_id' => 2,
			'user_id' => 1
		));
		DB::table('task_user')->insert(array(
			'id' 	=> 3,
			'task_id' => 2,
			'user_id' => 2
		));	
		DB::table('task_user')->insert(array(
			'id' 	=> 4,
			'task_id' => 3,
			'user_id' => 3
		));	
	}
}
<?php

class StatusTasksTableSeeder extends Seeder {
	public function run()
	{
		DB::table('status_tasks')->insert(array(
			'id'	=> 1,
			'name'	=> 'not started'
		));
		DB::table('status_tasks')->insert(array(
			'id'	=> 2,
			'name'	=> 'in progress'
		));
		DB::table('status_tasks')->insert(array(
			'id'	=> 3,
			'name'	=> 'waiting support'
		));
		DB::table('status_tasks')->insert(array(
			'id'	=> 4,
			'name'	=> 'subject to validations'
		));
		DB::table('status_tasks')->insert(array(
			'id'	=> 5,
			'name'	=> 'validated'
		));
		DB::table('status_tasks')->insert(array(
			'id'	=> 6,
			'name'	=> 'outstanding'
		));

	}
}
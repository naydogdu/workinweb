<?php

class TaskTableSeeder extends Seeder {
	public function run()
	{
		for ($i=1; $i < 6; $i++) { 
			DB::table('tasks_public')->insert(array(
			'id'			=> $i,
			'title' 		=> 'task public web'. $i,
			'public_type'	=> 1
			));
			DB::table('tasks_public')->insert(array(
			'id'			=> $i+5,
			'title' 		=> 'task public app mobile'. $i,
			'public_type'	=> 2
			));
			DB::table('tasks_public')->insert(array(
			'id'			=> $i+10,
			'title' 		=> 'task public print'. $i,
			'public_type'	=> 3
			));
		}	
	}
}
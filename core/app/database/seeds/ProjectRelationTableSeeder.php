<?php

class ProjectRelationTableSeeder extends Seeder {
	public function run()
	{
		for ($i = 1; $i < 6; $i++)
		{
			DB::table('projects_relations')->insert(array(
			'project_id' 	=> $i,
			'user_id'	=> 1,
			'user_permission_id' => 2
			));

			if($i == 5): $e = 2; else : $e = 1; endif;

			DB::table('projects_relations')->insert(array(
			'project_id' 	=> $i,
			'user_id'	=> 2,
			'user_permission_id' => $e
			));
		}

		DB::table('projects_relations')->insert(array(
			'project_id' 	=> 5,
			'user_id'	=> 4,
			'user_permission_id' => 1
		));

		DB::table('projects_relations')->insert(array(
			'project_id' 	=> 4,
			'user_id'	=> 4,
			'user_permission_id' => 3
		));

		DB::table('projects_relations')->insert(array(
			'project_id' 	=> 5,
			'user_id'	=> 3,
			'user_permission_id' => 2
		));

		DB::table('projects_relations')->insert(array(
			'project_id' 	=> 1,
			'user_id'	=> 3,
			'user_permission_id' => 2
		));


		DB::table('projects_relations')->insert(array(
			'project_id' 	=> 2,
			'user_id'	=> 3,
			'user_permission_id' => 2
		));

	}
}
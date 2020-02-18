<?php

class TypesProjectsTableSeeder extends Seeder {
	public function run()
	{
		DB::table('types_projects')->insert(array(
			'id'	=> 1,
			'name'	=> 'Web'
		));

		DB::table('types_projects')->insert(array(
			'id'	=> 2,
			'name'	=> 'App mobile'
		));
		
		DB::table('types_projects')->insert(array(
			'id'	=> 3,
			'name'	=> 'Print'
		));
	}
}
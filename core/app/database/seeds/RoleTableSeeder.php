<?php

class RoleTableSeeder extends Seeder {
	public function run()
	{
		DB::table('roles')->insert(array(
			'id'	=> 1,
			'role' 	=> 'admin'
		));

		DB::table('roles')->insert(array(
			'id'	=> 2,
			'role'	=> 'user'
		));
	}
}
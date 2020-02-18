<?php

class UserPermissionTableSeeder extends Seeder {
	public function run()
	{
		DB::table('users_permissions')->insert(array(
			'id'	=> 1,
			'permission' 	=> 'chef-projet',
			'name'	=> 'Chef de Projet'
		));

		DB::table('users_permissions')->insert(array(
			'id'	=> 2,
			'permission'	=> 'intervenant',
			'name'	=> 'Intervenant'
		));
		
		DB::table('users_permissions')->insert(array(
			'id'	=> 3,
			'permission'	=> 'client',
			'name'	=> 'Client'
		));
	}
}
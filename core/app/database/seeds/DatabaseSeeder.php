<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		$this->call('StatusTasksTableSeeder');
		$this->call('TypesProjectsTableSeeder');
		$this->call('RoleTableSeeder');
		$this->call('UserTableSeeder');
		$this->call('SocietyTableSeeder');
		$this->call('ProjectTableSeeder');
		$this->call('TaskTableSeeder');
		$this->call('TaskProjectTableSeeder');
		$this->call('TaskUserTableSeeder');	
		$this->call('TicketTableSeeder');
		$this->call('ProjectRelationTableSeeder');
		$this->call('UserPermissionTableSeeder');
		
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}

}

<?php

class UserTableSeeder extends Seeder {

	private function randDate()
	{
		return date("Y-m-d H:i:s", mt_rand(strtotime('Jan 01 2010'),strtotime('Dec 31 2013')));
	}

	public function run()
	{
		$date = $this->randDate();
		DB::table('users')->insert(array(
			'email'			=> 'nazmi@grapheek.com',
			'password'		=> Hash::make('secret'),
			'created_at' 	=> $date,
			'updated_at'	=> $date,
			'role_id'		=> 1,
			'society_id' 	=> 1
		));
		$date = $this->randDate();
		DB::table('users')->insert(array(
			'email'			=> 'paul@anthedesign.fr',
			'password'		=> Hash::make('secret'),
			'created_at' 	=> $date,
			'updated_at'	=> $date,
			'role_id'		=> 1,
			'society_id'	=> 1
		));
		$date = $this->randDate();
		DB::table('users')->insert(array(
			'email'			=> 'test@test.fr',
			'password'		=> Hash::make('test'),
			'created_at' 	=> $date,
			'updated_at'	=> $date,
			'role_id'		=> 2,
			'society_id'	=> 1
		));
		$date = $this->randDate();
		DB::table('users')->insert(array(
			'email'			=> 'test2@test.fr',
			'password'		=> Hash::make('test2'),
			'created_at' 	=> $date,
			'updated_at'	=> $date,
			'role_id'		=> 1,
			'society_id'	=> 1
		));

		for ($i = 0; $i < 15; ++$i) 
		{
			$date = $this->randDate();
			DB::table('users')->insert(array(
				'email'			=> 'email' . $i . '@gmail.com',
				'password'		=> Hash::make('password' . $i),
				'created_at' 	=> $date,
				'updated_at'	=> $date,
				'role_id'		=> 2,
				'society_id' 	=> rand(2,3)
			));
		}
	}
}
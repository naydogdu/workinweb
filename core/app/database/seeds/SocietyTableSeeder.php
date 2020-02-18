<?php

class SocietyTableSeeder extends Seeder {

	private function randDate()
	{
		return date("Y-m-d H:i:s", mt_rand(strtotime('Jan 01 2010'),strtotime('Dec 31 2013')));
	}

	public function run()
	{
		for ($i = 0; $i < 3; ++$i) 
		{
			$date = $this->randDate();
			DB::table('societys')->insert(array(
				'siret'			=> rand(100000, 999999) . rand(100000, 999999),
				'creator_id'	=> rand(5, 7),
				'name'          => 'Entreprise ' . rand(10, 1000),
				'created_at' 	=> $date,
				'updated_at'	=> $date				
			));
		}
	}
}
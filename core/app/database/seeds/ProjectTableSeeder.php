<?php

class ProjectTableSeeder extends Seeder {
	private function createHashUrl($length = 10)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	public function run()
	{
		$hash = $this->createHashUrl();
		DB::table('projects')->insert(array(
			'id'	=> 1,
			'generated_url' 	=> 1 . $hash,
			'name' 	=> 'Projet Alpha',
			'description' 	=> 'Per hoc minui studium suum existimans Paulus, ut erat in conplicandis negotiis artifex dirus, unde ei Catenae inditum est cognomentum.',
			'type_project_id' => 1,
			'begin_date'	=> '2015-02-08',
			'end_date'		=> '2015-03-05',
			'society_id'	=> 1
		));
		
		$hash = $this->createHashUrl();
		DB::table('projects')->insert(array(
			'id'	=> 2,
			'generated_url'	=> 2 . $hash,
			'name' 	=> 'Projet Bravo',
			'description' 	=> 'Illud tamen te esse admonitum volo, primum ut qualis es talem te esse omnes existiment ut, quantum a rerum turpitudine abes, tantum te a verborum libertate seiungas; deinde ut ea in alterum ne dicas.',
			'type_project_id' => 2,
			'begin_date'	=> '2015-02-15',
			'end_date'		=> '2015-04-02',
			'society_id'	=> 1
		));

		$hash = $this->createHashUrl();
		DB::table('projects')->insert(array(
			'id'	=> 3,
			'generated_url'	=> 3 . $hash,
			'name' 	=> 'Projet Charlie',
			'description' 	=> 'Illud tamen te esse admonitum volo, primum ut qualis es talem te esse omnes existiment ut, quantum a rerum turpitudine abes, tantum te a verborum libertate seiungas; deinde ut ea in alterum ne dicas.',
			'type_project_id' => 3,
			'begin_date'	=> '2015-03-15',
			'end_date'		=> '2015-05-04',
			'society_id'	=> 1
		));

		$hash = $this->createHashUrl();
		DB::table('projects')->insert(array(
			'id'	=> 4,
			'generated_url'	=> 4 . $hash,
			'name' 	=> 'Projet Delta',
			'description' 	=> "Lorem Elsass ipsum ftomi! elementum schneck wie adipiscing réchime leverwurscht sit consectetur so lotto-owe non kougelhopf rossbolla leo aliquam Huguette gal Pfourtz ! munster blottkopf, Hans hopla bissame merci vielmols geïz libero, quam, barapli geht's ornare Richard Schirmeck et id, sed ac mollis Yo dû. nüdle porta Mauris eleifend Christkindelsmärik rucksack turpis, messti de Bischheim dui condimentum amet morbi amet lacus vielmols, Gal ! semper suspendisse elit Strasbourg gewurztraminer hoplageiss varius sagittis dolor kuglopf Wurschtsalad mänele risus, bredele commodo und Salut bisamme Pellentesque placerat gravida ullamcorper picon bière pellentesque kartoffelsalad in, libero, vulputate Verdammi Chulien wurscht tchao bissame Carola DNA, tristique s'guelt non schpeck turpis nullam ante hopla knack Kabinetpapier sit Chulia Roberstau mamsell schnaps habitant baeckeoffe Gal. amet, Spätzle jetz gehts los Heineken flammekueche knepfle Racing. Morbi Oberschaeffolsheim eget ornare senectus météor salu quam. ch'ai Salu bissame auctor, hop rhoncus Miss Dahlias tellus sit Oberschaeffolsheim sed libero. Coopé de Truchtersheim id yeuh. dignissim tellus leo hopla purus ac chambon hopla .",
			'type_project_id' => 1,
			'begin_date'	=> '2015-02-09',
			'end_date'		=> '2015-06-01',
			'society_id'	=> 1
		));
		
		$hash = $this->createHashUrl();
		DB::table('projects')->insert(array(
			'id'	=> 5,
			'generated_url'	=> 5 . $hash,
			'name' 	=> 'Projet Echo',
			'description' 	=> "Oberschaeffolsheim mollis bissame Hans hoplageiss messti de Bischheim id, habitant geht's schnaps munster ac gal auctor, senectus elit rucksack Yo dû. rhoncus knepfle elementum Pellentesque turpis, Salu bissame id ac vielmols, et eleifend mänele turpis hopla in, ch'ai Huguette semper vulputate sit Coopé de Truchtersheim hopla quam. leo non bredele morbi varius sed nullam sagittis so Mauris Strasbourg libero, leo Oberschaeffolsheim dui adipiscing knack suspendisse eget lotto-owe libero." ,
			'type_project_id' => 1,
			'begin_date'	=> '2015-02-08',
			'end_date'		=> '2015-03-24',
			'society_id'	=> 1
		));
	}
}
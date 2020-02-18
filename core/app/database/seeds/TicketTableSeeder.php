<?php

class TicketTableSeeder extends Seeder {
	public function run()
	{
		DB::table('tickets')->insert(array(
			'id'	=> 1,
			'ticketable_id' => 1,
			'ticketable_type' => 'project',
			'author_id' => 2,
			'content' 	=> 'Atque, ut Tullius ait, ut etiam ferae fame monitae plerumque ad eum locum ubi aliquando pastae sunt revertuntur, ita homines instar turbinis degressi montibus impeditis et arduis loca petivere mari confinia, per quae viis.'	
		));
		
		DB::table('tickets')->insert(array(
			'id'	=> 2,
			'ticketable_id' => 2,
			'ticketable_type' => 'task',
			'author_id' => 2,
			'content' 	=> 'Quam ob rem cave Catoni anteponas ne istum quidem ipsum, quem Apollo, ut ais, sapientissimum iudicavit; huius enim facta, illius dicta laudantur. De me autem, ut iam cum utroque vestrum loquar, sic habetote.'
		));
	
		DB::table('tickets')->insert(array(
			'id'	=> 3,
			'ticketable_id' => 2,
			'ticketable_type' => 'project',
			'author_id' => 1,
			'content' 	=> 'Apollo, ut ais, sapientissimum iudicavit; huius enim facta, illius dicta laudantur. De me autem, ut iam cum utroque vestrum loquar, sic habetote.'
		));
	}
}
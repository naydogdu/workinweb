<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocietysTable extends Migration {

	public function up()
	{
		Schema::create('societys', function(Blueprint $table) {
			$table->increments('id');		
			$table->string('siret', 100)->unique();
            $table->integer('creator_id')->unsigned();
			$table->string('name');
			$table->timestamps();	
		});
	}

	public function down()
	{
		Schema::drop('societys');
	}

}

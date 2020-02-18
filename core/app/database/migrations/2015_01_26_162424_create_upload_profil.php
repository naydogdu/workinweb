<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadProfil extends Migration {

	
	public function up()
	{
		Schema::create('upload_profil', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('upload_id')->unsigned();
			$table->integer('profil_id')->unsigned();
		});
	}

	
	public function down()
	{
		Schema::drop('upload_profil');
	}

}

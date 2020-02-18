<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profils', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('first_name', 55)->nullable();
			$table->string('last_name', 55)->nullable();
			$table->enum('gender', array('male', 'female', 'other'))->nullable();
			$table->date('birthday')->nullable();
			$table->string('occupation')->nullable();
			$table->integer('user_id')->unsigned();
			$table->integer('avatar_id')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('profils');
	}

}

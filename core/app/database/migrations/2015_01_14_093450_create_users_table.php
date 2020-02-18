<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Users Table
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');		
			$table->string('email', 100)->unique();
			$table->string('password', 64);
            $table->string('remember_token', 100)->nullable();
            $table->integer('role_id')->unsigned();
			$table->integer('society_id')->unsigned()->nullable()->default(null);
			$table->timestamps();	
		});
	}

	public function down()
	{
		Schema::drop('users');
	}

}

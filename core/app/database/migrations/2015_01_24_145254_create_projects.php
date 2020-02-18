<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjects extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('projects', function(Blueprint $table) {
			$table->increments('id');
			$table->string('generated_url', 16);
			$table->string('name', 100);
			$table->text('description');
			$table->integer('type_project_id')->unsigned();
			$table->date('begin_date')->nullable();
			$table->date('end_date')->nullable();
			$table->integer('society_id')->unsigned();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('projects');
	}

}

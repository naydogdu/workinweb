<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsRelations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('projects_relations', function(Blueprint $table) {
			
			$table->integer('project_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('user_permission_id')->unsigned();
			$table->primary(array('project_id', 'user_id'), 'project_new');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('projects_relations');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table){
			$table->foreign('role_id')->references('id')->on('roles');
			$table->foreign('society_id')->references('id')->on('societys');
		});
		Schema::table('projects_relations', function(Blueprint $table){
			$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('user_permission_id')->references('id')->on('users_permissions')->onDelete('cascade');
		});
		Schema::table('profils', function(Blueprint $table){
			$table->foreign('user_id')->references('id')->on('users');
		});
		Schema::table('upload_profil', function(Blueprint $table) {
			$table->foreign('upload_id')->references('id')->on('uploads')->onDelete('cascade');
			$table->foreign('profil_id')->references('id')->on('profils')->onDelete('cascade');
		});
		Schema::table('projects', function(Blueprint $table) {
			$table->foreign('type_project_id')->references('id')->on('types_projects');
			$table->foreign('society_id')->references('id')->on('societys');
		});
		Schema::table('task_user', function(Blueprint $table) {
			$table->foreign('task_id')->references('id')->on('tasks');
			$table->foreign('user_id')->references('id')->on('users');
		});
		Schema::table('task_project', function(Blueprint $table) {
			$table->foreign('task_id')->references('id')->on('tasks');
			$table->foreign('project_id')->references('id')->on('projects');
			$table->foreign('status_id')->references('id')->on('status_tasks');
		});
		Schema::table('tasks_public', function(Blueprint $table){
			$table->foreign('public_type')->references('id')->on('types_projects');
		});


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{	
		Schema::table('users', function(Blueprint $table) {
			$table->dropForeign('users_role_id_foreign');
			$table->dropForeign('users_society_id_foreign');
		});
		Schema::table('projects_relations', function(Blueprint $table) {
			$table->dropForeign('projects_relations_project_id_foreign');
			$table->dropForeign('projects_relations_user_id_foreign');
			$table->dropForeign('projects_relations_user_permission_id_foreign');
		});
		Schema::table('profils', function(Blueprint $table){
			$table->dropForeign('profils_user_id_foreign');
		});
		Schema::table('upload_profil', function(Blueprint $table) {
			$table->dropForeign('upload_profil_upload_id_foreign');
			$table->dropForeign('upload_profil_profil_id_foreign');
		});
		Schema::table('projects', function(Blueprint $table) {
			$table->dropForeign('projects_type_project_id_foreign');
			$table->dropForeign('projects_society_id_foreign');
		});
		Schema::table('task_user', function(Blueprint $table) {
			$table->dropForeign('task_user_task_id_foreign');
			$table->dropForeign('task_user_user_id_foreign');
		});
		Schema::table('task_project', function(Blueprint $table) {
			$table->dropForeign('task_project_task_id_foreign');
			$table->dropForeign('task_project_project_id_foreign');
			$table->dropForeign('task_project_status_id_foreign');
		});
		Schema::table('tasks_public', function(Blueprint $table){
			$table->dropForeign('tasks_public_public_type_foreign');
		});

	}

}

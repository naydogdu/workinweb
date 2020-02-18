<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::unprepared('
             	CREATE TRIGGER `after_insert_users` AFTER INSERT ON `ww_users`
				FOR EACH ROW 
				Insert into ww_profils (user_id) VALUE (NEW.id)
        ');

		DB::unprepared('
             	CREATE TRIGGER `before_delete_users` BEFORE DELETE ON `ww_users`
				FOR EACH ROW 
				Delete from ww_profils where user_id = OLD.id
        ');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::unprepared('DROP TRIGGER `after_insert_users`');
		DB::unprepared('DROP TRIGGER `before_delete_users`');
	}

}

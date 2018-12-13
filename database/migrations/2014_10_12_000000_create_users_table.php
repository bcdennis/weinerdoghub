<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('name', 30)->unique();
			$table->string('email', 191)->unique();
			$table->string('password', 60)->nullable();
            $table->string('avatar', 191)->nullable();
            $table->string('permission', 20)->default('user');
            $table->boolean('blocked')->default(false);
            $table->tinyInteger('status')->default(0)->unsigned();
            $table->string('confirmation_code', 30)->nullable();

            // Cache fields
            $table->integer('comments')->default(0)->unsigned();
            $table->integer('posts')->default(0)->unsigned();
            $table->integer('likes')->default(0)->unsigned();
			$table->integer('dislikes')->default(0)->unsigned();
            $table->integer('points')->default(0);

			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}

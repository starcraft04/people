<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('username', 100)->unique();
			$table->string('email', 255)->unique();
			$table->string('password', 60);
			$table->rememberToken('rememberToken');
			$table->integer('employee_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}
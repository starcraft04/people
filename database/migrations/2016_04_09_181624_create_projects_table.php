<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectsTable extends Migration {

	public function up()
	{
		Schema::create('projects', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('customer_name', 255)->unique();
			$table->string('project_name', 255)->unique();
			$table->string('task_name', 255)->unique();
		});
	}

	public function down()
	{
		Schema::drop('projects');
	}
}
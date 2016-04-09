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
			$table->string('meta_activity', 255)->unique();
			$table->integer('year')->unique();
			$table->string('month', 10)->unique();
			$table->integer('task_hours');
			$table->integer('employee_id')->unique()->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('projects');
	}
}
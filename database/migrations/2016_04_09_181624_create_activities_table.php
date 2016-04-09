<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivitiesTable extends Migration {

	public function up()
	{
		Schema::create('activities', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('meta_activity', 255)->unique();
			$table->integer('year')->unique();
			$table->string('month', 10)->unique();
			$table->integer('project_id')->unsigned();
			$table->integer('task_hours');
			$table->integer('employee_id')->unique()->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('activities');
	}
}
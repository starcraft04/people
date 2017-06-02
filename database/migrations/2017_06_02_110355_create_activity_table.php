<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivityTable extends Migration {

	public function up()
	{
		Schema::create('activity', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('year');
			$table->integer('month')->nullable();
			$table->integer('project_id')->unsigned();
			$table->float('task_hour');
			$table->boolean('forecast')->nullable();
			$table->boolean('from_otl')->nullable();
			$table->integer('employee_id')->unsigned();
			$table->timestamp('created_at')->nullable();
			$table->timestamp('updated_at')->nullable();
		});
		DB::statement("ALTER TABLE `activity` ADD UNIQUE( `year`, `month`, `project_id`, `employee_id`);");
	}

	public function down()
	{
		Schema::drop('activity');
	}
}

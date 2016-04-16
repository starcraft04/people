<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivityTable extends Migration {

	public function up()
	{
		Schema::create('activity', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('meta_activity', 255)->unique();
			$table->integer('year')->unique();
			$table->string('month', 10)->unique();
			$table->integer('project_id')->unsigned();
			$table->float('task_hour');
			$table->boolean('from_otl')->nullable();
			$table->integer('employee_id')->unique()->unsigned();
            $table->unique(['employee_id', 'project_id', 'year', 'month', 'meta_activity']);
		});
	}

	public function down()
	{
		Schema::drop('activity');
	}
}
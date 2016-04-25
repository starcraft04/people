<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivityTable extends Migration {

	public function up()
	{
		Schema::create('activity', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('year');
			$table->string('month', 10);
			$table->integer('project_id')->unsigned();
			$table->float('task_hour');
			$table->boolean('from_otl')->nullable();
			$table->integer('employee_id')->unsigned();
		});
        DB::statement("ALTER TABLE `activity` ADD UNIQUE( `year`, `month`, `project_id`, `employee_id`);");
    }

	public function down()
	{
		Schema::drop('activity');
	}
}
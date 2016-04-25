<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamTaskTable extends Migration {

	public function up()
	{
		Schema::create('team_task', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 100);
			$table->string('severity', 100)->nullable();
			$table->date('begin_date')->nullable();
			$table->date('end_date')->nullable();
			$table->text('description')->nullable();
			$table->integer('employee_id')->unsigned();
			$table->integer('project_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('team_task');
	}
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectsTable extends Migration {

	public function up()
	{
		Schema::create('projects', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('customer_name', 255);
			$table->string('project_name', 255);
			$table->string('task_name', 255);
			$table->boolean('from_otl')->nullable();
            $table->unique(['customer_name', 'project_name', 'task_name']);
		});
        //DB::statement('ALTER TABLE projects MODIFY guestid INTEGER NOT NULL AUTO_INCREMENT');
	}

	public function down()
	{
		Schema::drop('projects');
	}
}
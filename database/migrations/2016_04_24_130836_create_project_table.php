<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectTable extends Migration {

	public function up()
	{
		Schema::create('project', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('customer_name', 100);
			$table->string('project_name', 100);
			$table->string('task_name', 100);
			$table->boolean('from_otl')->nullable();
			$table->string('project_type', 100);
			$table->string('task_category', 100);
			$table->string('meta_activity', 100);
			$table->string('region', 100)->nullable();
			$table->string('country', 100)->nullable();
		});
        DB::statement("ALTER TABLE `project` ADD UNIQUE( `customer_name`, `project_name`, `task_name`, `meta_activity`);");
    }

	public function down()
	{
		Schema::drop('project');
	}
}
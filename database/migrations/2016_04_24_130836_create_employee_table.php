<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmployeeTable extends Migration {

	public function up()
	{
		Schema::create('employee', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 100)->unique();
			$table->integer('manager_id')->unsigned()->nullable();
			$table->boolean('is_manager')->nullable();
			$table->boolean('from_otl')->nullable();
			$table->string('region', 100)->nullable();
			$table->string('domain', 100)->nullable();
			$table->string('country', 100)->nullable();
			$table->string('subdomain', 100)->nullable();
			$table->boolean('from_step')->nullable();
			$table->string('management_code', 20)->nullable();
		});
	}

	public function down()
	{
		Schema::drop('employee');
	}
}
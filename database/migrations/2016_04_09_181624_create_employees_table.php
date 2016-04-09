<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmployeesTable extends Migration {

	public function up()
	{
		Schema::create('employees', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('employee_name', 60)->unique();
			$table->integer('manager_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('employees');
	}
}
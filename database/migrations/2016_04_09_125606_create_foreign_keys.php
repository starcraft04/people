<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('employees', function(Blueprint $table) {
			$table->foreign('manager_id')->references('id')->on('employees')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('projects', function(Blueprint $table) {
			$table->foreign('employee_id')->references('id')->on('employees')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('employees', function(Blueprint $table) {
			$table->dropForeign('employees_manager_id_foreign');
		});
		Schema::table('projects', function(Blueprint $table) {
			$table->dropForeign('projects_employee_id_foreign');
		});
	}
}
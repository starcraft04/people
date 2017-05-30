<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('employee', function(Blueprint $table) {
			$table->foreign('manager_id')->references('id')->on('employee')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('activity', function(Blueprint $table) {
			$table->foreign('project_id')->references('id')->on('project')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('activity', function(Blueprint $table) {
			$table->foreign('employee_id')->references('id')->on('employee')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('skill', function(Blueprint $table) {
			$table->foreign('employee_id')->references('id')->on('employee')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('users', function(Blueprint $table) {
			$table->foreign('employee_id')->references('id')->on('employee')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('employee', function(Blueprint $table) {
			$table->dropForeign('employee_manager_id_foreign');
		});
		Schema::table('activity', function(Blueprint $table) {
			$table->dropForeign('activity_project_id_foreign');
		});
		Schema::table('activity', function(Blueprint $table) {
			$table->dropForeign('activity_employee_id_foreign');
		});
		Schema::table('skill', function(Blueprint $table) {
			$table->dropForeign('skill_employee_id_foreign');
		});
		Schema::table('users', function(Blueprint $table) {
			$table->dropForeign('users_employee_id_foreign');
		});
	}
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectLoETable extends Migration {

	public function up()
	{
		Schema::create('project_loe', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('project_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->string('domain', 100)->nullable();
			$table->string('type', 100)->nullable();
			$table->string('location', 100)->nullable();
			$table->float('mandays');
			$table->string('description', 255)->nullable();
			$table->text('history')->nullable();
			$table->boolean('signoff')->nullable();
			$table->timestamp('created_at')->nullable();
			$table->timestamp('updated_at')->nullable();
		});

		Schema::table('project_loe', function(Blueprint $table) {
			$table->foreign('project_id')->references('id')->on('projects')
						->onDelete('restrict')
						->onUpdate('restrict');
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('project_loe', function(Blueprint $table) {
			$table->dropForeign('project_loe_project_id_foreign');
        });
		Schema::drop('project_loe');
	}
}

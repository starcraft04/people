<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActionsTable extends Migration {

	public function up()
	{
		Schema::create('actions', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('assigned_user_id')->unsigned();
			$table->string('name', 100);
			$table->string('section', 100)->nullable();
			$table->integer('project_id')->unsigned()->nullable();
			$table->string('status', 100)->nullable();
			$table->string('severity', 100)->nullable();
			$table->date('estimated_start_date')->nullable();
			$table->date('estimated_end_date')->nullable();
			$table->text('description')->nullable();
			$table->timestamp('created_at')->nullable();
			$table->timestamp('updated_at')->nullable();
		});

		DB::statement("ALTER TABLE `actions` ADD UNIQUE( `id`);");

		Schema::table('actions', function(Blueprint $table) {
			$table->foreign('project_id')->references('id')->on('projects')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('actions', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('actions', function(Blueprint $table) {
			$table->foreign('assigned_user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::drop('actions');
	}
}

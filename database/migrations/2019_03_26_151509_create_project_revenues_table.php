<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectRevenuesTable extends Migration {

	public function up()
	{
		Schema::create('project_revenues', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('project_id')->unsigned();
			$table->string('product_code', 100);
			$table->integer('year');
			$table->float('jan');
			$table->float('feb');
			$table->float('mar');
			$table->float('apr');
			$table->float('may');
			$table->float('jun');
			$table->float('jul');
			$table->float('aug');
			$table->float('sep');
			$table->float('oct');
			$table->float('nov');
			$table->float('dec');
		});
		DB::statement("ALTER TABLE `project_revenues` ADD UNIQUE( `project_id`, `product_code`, `year`);");

		Schema::table('project_revenues', function(Blueprint $table) {
			$table->foreign('project_id')->references('id')->on('projects')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('project_revenues', function(Blueprint $table) {
			$table->dropForeign('project_revenues_project_id_foreign');
        });
		Schema::drop('project_revenues');
	}
}

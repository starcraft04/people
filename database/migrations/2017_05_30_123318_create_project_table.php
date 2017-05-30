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
			$table->string('customer_location', 100)->nullable();
			$table->string('domain', 100)->nullable();
			$table->string('description', 255)->nullable();
			$table->date('estimated_end_date')->nullable();
			$table->string('comments', 255)->nullable();
			$table->float('LoE_onshore')->nullable();
			$table->float('LoE_nearshore')->nullable();
			$table->float('LoE_offshore')->nullable();
			$table->float('LoE_contractor')->nullable();
			$table->string('gold_order_number', 100)->nullable();
			$table->string('product_code', 100)->nullable();
			$table->string('revenue')->nullable();
			$table->string('project_status', 100)->nullable();
			$table->string('otl_project_code', 100)->nullable();
			$table->integer('win_ratio')->nullable();
			$table->string('estimated_start_date');
		});
        DB::statement("ALTER TABLE `project` ADD UNIQUE( `customer_name`, `project_name`, `task_name`, `meta_activity`);");
	}

	public function down()
	{
		Schema::drop('project');
	}
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGoldOrderTable extends Migration {

	public function up()
	{
		Schema::create('gold_order', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('project_id')->unsigned()->nullable();
			$table->string('number', 100)->unique();
			$table->integer('gold_revenue_id')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('gold_order');
	}
}
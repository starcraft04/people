<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGoldRevenueTable extends Migration {

	public function up()
	{
		Schema::create('gold_revenue', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('code', 100)->nullable();
			$table->float('amount')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('gold_revenue');
	}
}
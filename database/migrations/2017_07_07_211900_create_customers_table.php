<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomersTable extends Migration {

	public function up()
	{
		Schema::create('customers', function(Blueprint $table) {
			$table->increments('id');
			$table->string('customer_name', 100)->unique();
			$table->string('cluster_owner', 100)->nullable();
		});
	}

	public function down()
	{
		Schema::drop('customers');
	}
}

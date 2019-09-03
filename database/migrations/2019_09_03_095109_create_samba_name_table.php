<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSambaNameTable extends Migration {

	public function up()
	{
		Schema::create('samba_names', function(Blueprint $table) {
			$table->increments('id');
			$table->string('samba_name', 100);
			$table->string('dolphin_name', 100);
		});
		DB::statement("ALTER TABLE `samba_names` ADD UNIQUE( `samba_name`);");
	}

	public function down()
	{
		Schema::drop('samba_names');
	}
}

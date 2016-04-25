<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSkillTable extends Migration {

	public function up()
	{
		Schema::create('skill', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('skill_type', 100);
			$table->string('skill_category_name', 255);
			$table->string('skill', 255);
			$table->string('rank', 10);
            $table->string('target_rank', 10)->nullable();
			$table->date('employee_last_assessed')->nullable();
			$table->boolean('from_step')->nullable();
			$table->integer('employee_id')->unsigned();
		});
        DB::statement("ALTER TABLE `skill` ADD UNIQUE( `skill_type`, `skill_category_name`, `skill`, `employee_id`);");
	}

	public function down()
	{
		Schema::drop('skill');
	}
}
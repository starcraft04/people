<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skill_user', function(Blueprint $table) {
			$table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('skill_id')->unsigned();
			$table->integer('rating')->unsigned();
        });
        
        DB::statement("ALTER TABLE `skill_user` ADD UNIQUE( `user_id`, `skill_id`);");

        Schema::table('skill_user', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
        });
        
        Schema::table('skill_user', function(Blueprint $table) {
			$table->foreign('skill_id')->references('id')->on('skills')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('skill_user', function(Blueprint $table) {
			$table->dropForeign('skill_user_user_id_foreign');
        });
        Schema::table('skill_user', function(Blueprint $table) {
			$table->dropForeign('skill_user_skill_id_foreign');
        });
		Schema::drop('skill_user');
    }
}

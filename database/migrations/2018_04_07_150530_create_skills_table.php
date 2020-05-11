<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->increments('id');
            $table->string('domain', 100);
            $table->string('subdomain', 100);
            $table->string('technology', 100);
            $table->string('skill', 100);
            $table->boolean('certification')->nullable();
        });
        DB::statement('ALTER TABLE `skills` ADD UNIQUE( `domain`, `subdomain`, `technology`, `skill`);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('skills');
    }
}

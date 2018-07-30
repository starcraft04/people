<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `skills` DROP INDEX `domain`;");
		DB::statement("ALTER TABLE `skills` ADD UNIQUE( `domain`, `subdomain`, `technology`, `skill`, `certification`);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `skills` DROP INDEX `domain`;");
		DB::statement("ALTER TABLE `skills` ADD UNIQUE( `domain`, `subdomain`, `technology`, `skill`);");
    }
}

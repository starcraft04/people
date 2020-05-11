<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeOnshore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("UPDATE users SET employee_type = 'employee' WHERE employee_type = 'onshore';");
        DB::statement("UPDATE users SET employee_type = 'employee' WHERE employee_type = 'offshore';");
        DB::statement("UPDATE users SET employee_type = 'employee' WHERE employee_type = 'nearshore';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}

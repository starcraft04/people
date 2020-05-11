<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeASC extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("UPDATE users SET job_role = 'ASC' WHERE job_role = 'DSC';");
        DB::statement("UPDATE projects SET activity_type = 'ASC' WHERE activity_type = 'DSC';");
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

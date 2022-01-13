<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePracitceService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement("UPDATE users SET domain = 'IT Assurance and Performance' WHERE domain = 'Service Assurance and Performance';");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
     DB::statement("UPDATE users SET domain = 'Service Assurance and Performance' WHERE domain = 'IT Assurance and Performance';");
    }
}

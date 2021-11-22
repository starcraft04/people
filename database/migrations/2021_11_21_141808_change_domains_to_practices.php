<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDomainsToPractices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("UPDATE users SET domain = '' WHERE domain = 'GCP';");
        DB::statement("UPDATE users SET domain = '' WHERE domain = 'OGSB';");
        DB::statement("UPDATE users SET domain = '' WHERE domain = 'Hybrid';");
        DB::statement("UPDATE users SET domain = 'Business Cybersecurity' WHERE domain = 'Security';");
        DB::statement("UPDATE users SET domain = 'Service Assurance and Performance' WHERE domain = 'APM';");
        DB::statement("UPDATE users SET domain = 'Cloud Networking' WHERE domain = 'Network';");
        DB::statement("UPDATE users SET domain = 'Employee Experience' WHERE domain = 'UC';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("UPDATE users SET domain = 'GCP' WHERE domain = '';");
        DB::statement("UPDATE users SET domain = 'GCP' WHERE domain = '';");
        DB::statement("UPDATE users SET domain = 'GCP' WHERE domain = '';");
        DB::statement("UPDATE users SET domain = 'Hybrid Security' WHERE domain = 'Security';");
        DB::statement("UPDATE users SET domain = 'Hybrid APM' WHERE domain = 'APM';");
        DB::statement("UPDATE users SET domain = 'Hybrid Network' WHERE domain = 'Network';");
        DB::statement("UPDATE users SET domain = 'UC' WHERE domain = 'UC';");
    }
}

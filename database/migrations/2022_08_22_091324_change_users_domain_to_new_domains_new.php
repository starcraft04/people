<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUsersDomainToNewDomainsNew extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("UPDATE users SET domain = 'IT Performance and Assurance' WHERE domain = 'IT Performance and Assurance';");
        DB::statement("UPDATE users SET domain = 'IT Performance and Assurance' WHERE domain = 'IT Assurance and Performance';");
        DB::statement("UPDATE users SET domain = 'Cloud and Data Digitalization' WHERE domain = 'Digital Data and Cloud';");
        DB::statement("UPDATE users SET domain = 'Security and Compliance' WHERE domain = 'Security';");
        DB::statement("UPDATE users SET domain = 'Security and Compliance' WHERE domain = 'Business Cybersecurity';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('new_domains_new', function (Blueprint $table) {
            //
        });
    }
}

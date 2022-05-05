<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateResourceRequestStr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('resources_request', function (Blueprint $table) {
        $table->string('Budgeted',50)->change();
        $table->string('case_status',50)->change();
        $table->string('EWR_status',50)->change();
        $table->string('internal_check  ',50)->change();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

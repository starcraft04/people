<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIc01Tables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customerIC01', function (Blueprint $table) {
            //
            $table->id();
            $table->string('ic01_name');
            $table->integer('ic01_code');
            $table->integer('customer_id');

            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customerIC01', function (Blueprint $table) {
            //
        });
    }
}

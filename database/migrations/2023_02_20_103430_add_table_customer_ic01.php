<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableCustomerIc01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //add new table Customer_IC01
Schema::create('customer_ic01', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->integer('customer_id')->nullable();
        $table->string(' ic01_name')->nullable();
        $table->integer('ic01_code')->nullable();
        
        $table->timestamps();

        $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
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
        Schema::drop('customer_ic01');
    }
}

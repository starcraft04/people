<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoeHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_loe_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_loe_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('field_modified', 50)->nullable();
            $table->string('field_new_value', 50)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::table('project_loe_history', function (Blueprint $table) {
            $table->foreign('project_loe_id')->references('id')->on('project_loe')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');
            $table->foreign('user_id')->references('id')->on('users')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');
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

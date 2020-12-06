<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyLoe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Then we need to change the way the table is structured
        Schema::table('project_loe', function (Blueprint $table) {
            $table->dropForeign('project_loe_project_id_foreign');
        });
        Schema::table('project_loe', function (Blueprint $table) {
            $table->dropForeign('project_loe_user_id_foreign');
        });
        Schema::drop('project_loe');

        // Then we need to change the way the table is structured
        Schema::create('project_loe', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('main_phase', 50)->nullable();
            $table->string('secondary_phase', 50)->nullable();
            $table->string('domain', 50)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('option', 50)->nullable();
            $table->string('assumption', 255)->nullable();
            $table->float('quantity')->default(1);
            $table->float('loe_per_quantity')->default(1);
            $table->string('formula', 255)->nullable();
            $table->boolean('recurrent')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('signoff_user_id')->nullable()->unsigned();
            $table->boolean('first_line')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::table('project_loe', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');
            $table->foreign('user_id')->references('id')->on('users')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');
            $table->foreign('signoff_user_id')->references('id')->on('users')
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

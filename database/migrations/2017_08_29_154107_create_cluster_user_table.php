<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClusterUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cluster_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('cluster_id')->unsigned();
        });

        Schema::table('cluster_user', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');
        });

        Schema::table('cluster_user', function (Blueprint $table) {
            $table->foreign('cluster_id')->references('id')->on('clusters')
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
        Schema::table('cluster_user', function (Blueprint $table) {
            $table->dropForeign('cluster_user_user_id_foreign');
        });
        Schema::table('cluster_user', function (Blueprint $table) {
            $table->dropForeign('cluster_user_cluster_id_foreign');
        });
        Schema::drop('cluster_user');
    }
}

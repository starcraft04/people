<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeClusterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cluster_user', function (Blueprint $table) {
            $table->dropForeign('cluster_user_cluster_id_foreign');
        });
        Schema::table('cluster_user', function (Blueprint $table) {
            $table->string('cluster_owner', 100);
        });
        Schema::table('cluster_user', function (Blueprint $table) {
            $table->dropColumn('cluster_id');
        });
        Schema::table('cluster_country', function (Blueprint $table) {
            $table->dropForeign('cluster_country_cluster_id_foreign');
        });
        Schema::drop('cluster_country');
        Schema::drop('clusters');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('clusters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->unique();
        });
        Schema::create('cluster_country', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cluster_id')->unsigned();
            $table->string('country', 100);
        });
        Schema::table('cluster_country', function (Blueprint $table) {
            $table->foreign('cluster_id')->references('id')->on('clusters')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');
        });
        Schema::table('cluster_user', function (Blueprint $table) {
            $table->integer('cluster_id')->unsigned();
        });
        Schema::table('cluster_user', function (Blueprint $table) {
            $table->dropColumn('cluster_owner');
        });
        Schema::table('cluster_user', function (Blueprint $table) {
            $table->foreign('cluster_id')->references('id')->on('clusters')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');
        });
    }
}

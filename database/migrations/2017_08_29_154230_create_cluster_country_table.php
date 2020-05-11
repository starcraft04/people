<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClusterCountryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cluster_country', function (Blueprint $table) {
            $table->dropForeign('cluster_country_cluster_id_foreign');
        });

        Schema::drop('countries');
    }
}

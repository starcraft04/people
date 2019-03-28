<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUserTargets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('revenue_product_codes', 100)->nullable();
            $table->float('revenue_target',15,2)->nullable();
            $table->float('order_target',15,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('revenue_product_codes');
            $table->dropColumn('revenue_target');
            $table->dropColumn('order_target');
        });
    }
}

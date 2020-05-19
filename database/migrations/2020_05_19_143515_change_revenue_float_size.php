<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeRevenueFloatSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('revenues', function (Blueprint $table) {
            $table->float('jan',15,2)->nullable()->change();
            $table->float('feb',15,2)->nullable()->change();
            $table->float('mar',15,2)->nullable()->change();
            $table->float('apr',15,2)->nullable()->change();
            $table->float('may',15,2)->nullable()->change();
            $table->float('jun',15,2)->nullable()->change();
            $table->float('jul',15,2)->nullable()->change();
            $table->float('aug',15,2)->nullable()->change();
            $table->float('sep',15,2)->nullable()->change();
            $table->float('oct',15,2)->nullable()->change();
            $table->float('nov',15,2)->nullable()->change();
            $table->float('dec',15,2)->nullable()->change();
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

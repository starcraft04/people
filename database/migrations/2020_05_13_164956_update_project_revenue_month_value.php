<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProjectRevenueMonthValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_revenues', function (Blueprint $table) {
            $table->float('jan')->default(0)->change();
            $table->float('feb')->default(0)->change();
            $table->float('mar')->default(0)->change();
            $table->float('apr')->default(0)->change();
            $table->float('may')->default(0)->change();
            $table->float('jun')->default(0)->change();
            $table->float('jul')->default(0)->change();
            $table->float('aug')->default(0)->change();
            $table->float('sep')->default(0)->change();
            $table->float('oct')->default(0)->change();
            $table->float('nov')->default(0)->change();
            $table->float('dec')->default(0)->change();
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

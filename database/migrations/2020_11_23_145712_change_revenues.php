<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeRevenues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('revenues', function (Blueprint $table) {
            $table->boolean('jan_actuals')->default(0)->after('jan');
            $table->boolean('mar_actuals')->default(0)->after('mar');
            $table->boolean('feb_actuals')->default(0)->after('feb');
            $table->boolean('apr_actuals')->default(0)->after('apr');
            $table->boolean('may_actuals')->default(0)->after('may');
            $table->boolean('jun_actuals')->default(0)->after('jun');
            $table->boolean('jul_actuals')->default(0)->after('jul');
            $table->boolean('aug_actuals')->default(0)->after('aug');
            $table->boolean('sep_actuals')->default(0)->after('sep');
            $table->boolean('oct_actuals')->default(0)->after('oct');
            $table->boolean('nov_actuals')->default(0)->after('nov');
            $table->boolean('dec_actuals')->default(0)->after('dec');
        });
        DB::statement("UPDATE revenues SET jan_actuals = 1,feb_actuals = 1,mar_actuals = 1,apr_actuals = 1,may_actuals = 1,jun_actuals = 1,jul_actuals = 1,aug_actuals = 1,sep_actuals = 1,oct_actuals = 1,nov_actuals = 1,dec_actuals = 1;");
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}

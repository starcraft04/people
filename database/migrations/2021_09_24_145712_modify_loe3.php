<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class ModifyLoe3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // First we need to add some new fields
        Schema::table('project_loe', function (Blueprint $table) {
            $table->float('fte')->nullable(false)->default(0)->after('loe_per_quantity');
            $table->float('num_of_months')->nullable(false)->default(0)->after('recurrent');
            $table->integer('row_order')->unsigned()->default(1)->after('id');
        });

        // Then we need to set all the row_orders for the existing records
        DB::statement("UPDATE project_loe SET row_order = 1;");
        // Then we need to set all the fte and copy from loe_per_quantity
        DB::statement("UPDATE project_loe SET fte = loe_per_quantity WHERE recurrent = 1 ;");
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

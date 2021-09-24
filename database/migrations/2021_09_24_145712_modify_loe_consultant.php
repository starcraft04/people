<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class ModifyLoeConsultant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // First we need to change and prevent nullable for some fields
        Schema::table('project_loe_consultant', function (Blueprint $table) {
            $table->string('name', 50)->nullable(false)->change();
            $table->string('location', 50)->nullable(false)->change();
            $table->string('seniority', 50)->nullable(false)->change();
            $table->float('price')->nullable(false)->default(0)->change();
            $table->float('cost')->nullable(false)->default(0)->change();
            $table->float('percentage')->nullable(false)->default(100)->change();
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

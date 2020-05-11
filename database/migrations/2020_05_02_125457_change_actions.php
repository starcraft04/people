<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeActions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('actions', function (Blueprint $table) {
            $table->float('percent_complete')->after('status');
            $table->text('next_action_description')->nullable();
            $table->text('next_action_dependency')->nullable();
            $table->date('next_action_due_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('actions', function (Blueprint $table) {
            $table->dropColumn('next_action_description');
            $table->dropColumn('next_action_dependency');
            $table->dropColumn('next_action_due_date');
        });
    }
}

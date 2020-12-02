<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoeConsultant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_loe_consultant', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_loe_id')->unsigned();
            $table->string('name', 50)->nullable();
            $table->string('location', 50)->nullable();
            $table->string('seniority', 50)->nullable();
            $table->float('price')->nullable();
            $table->float('percentage')->default(100);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        DB::statement('ALTER TABLE `project_loe_consultant` ADD UNIQUE( `project_loe_id`, `name`);');

        Schema::table('project_loe_consultant', function (Blueprint $table) {
            $table->foreign('project_loe_id')->references('id')->on('project_loe')
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
        //
    }
}

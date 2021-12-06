<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReourcesRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reources_request', function (Blueprint $table) {
            $table->increments('id');

            $table->boolean('Budgeted')->default(0);
            $table->string('consulting_request',255);
            $table->string('PR',255)->nullable();
            $table->string('PO',255)->nullable();
            $table->string('practice',255)->nullable();
            $table->string('duration',255);
            $table->boolean('case_status')->default(0);
            $table->boolean('EWR_status')->default(0);
            $table->string('supplier',255)->nullable();
            $table->bigInteger('revenue')->unsigned(); 
            $table->bigInteger('cost')->unsigned(); 
            $table->string('currency',255)->nullable();
            $table->bigInteger('margin'); 
            $table->boolean('internal_check')->nullable();
            $table->text('reason_for_request')->nullable();
            $table->text('description')->nullable();
            $table->text('contractor_name')->nullable();
            $table->text('comments')->nullable();
            $table->date('last_update')->nullable(); 
            $table->date('date_of_complete')->nullable()->nullable(); 
                        
            $table->timestamps();
            
        });
        Schema::table('reources_request', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id');

                $table->foreign('user_id')->references('id')->on('users');
            });
            Schema::table('reources_request', function (Blueprint $table) {
                $table->unsignedBigInteger('project_id');

                $table->foreign('project_id')->references('id')->on('projects');
            });
            
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reources_request');
    }
}

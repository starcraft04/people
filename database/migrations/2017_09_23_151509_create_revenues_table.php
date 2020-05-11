<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRevenuesTable extends Migration
{
    public function up()
    {
        Schema::create('revenues', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->string('product_code', 100);
            $table->integer('year');
            $table->float('jan');
            $table->float('feb');
            $table->float('mar');
            $table->float('apr');
            $table->float('may');
            $table->float('jun');
            $table->float('jul');
            $table->float('aug');
            $table->float('sep');
            $table->float('oct');
            $table->float('nov');
            $table->float('dec');
        });
        DB::statement('ALTER TABLE `revenues` ADD UNIQUE( `customer_id`, `product_code`, `year`);');

        Schema::table('revenues', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');
        });
    }

    public function down()
    {
        Schema::table('revenues', function (Blueprint $table) {
            $table->dropForeign('revenues_customer_id_foreign');
        });
        Schema::drop('revenues');
    }
}

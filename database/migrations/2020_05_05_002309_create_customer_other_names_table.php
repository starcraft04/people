<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerOtherNamesTable extends Migration
{
    public function up()
    {
        Schema::create('customers_other_names', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->string('other_name', 100);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
        DB::statement('ALTER TABLE `customers_other_names` ADD UNIQUE( `other_name`);');

        Schema::table('customers_other_names', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');
        });
    }

    public function down()
    {
        Schema::table('customers_other_names', function (Blueprint $table) {
            $table->dropForeign('customers_other_names_customer_id_foreign');
        });
        Schema::drop('customers_other_names');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSambaUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('samba_users', function (Blueprint $table) {
            $table->id();
            $table->string('samba_name', 100);
            $table->string('dolphin_name', 100);
        });
        DB::statement('ALTER TABLE `samba_users` ADD UNIQUE( `samba_name`);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('samba_users');
    }
}

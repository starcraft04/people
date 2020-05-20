<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpgradeEntrust extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('permissions', 'permissions_backup');
        Schema::rename('roles', 'roles_backup');
        Schema::rename('permission_role', 'permission_role_backup');
        Schema::rename('role_user', 'role_user_backup');
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LoadSpatiePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        INSERT INTO `role_has_permissions`
            (permission_id,role_id)
        SELECT 
            permission_id,role_id
        FROM permission_role_backup;
        ");
        DB::statement("
        INSERT INTO `model_has_roles`
            (model_id,role_id)
        SELECT 
            user_id,role_id
        FROM role_user_backup;
        ");
        DB::statement("
        UPDATE `model_has_roles`
        SET model_type = 'App\\\User';
        ");
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

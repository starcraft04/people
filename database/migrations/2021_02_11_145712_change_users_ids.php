<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class ChangeUsersIds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('pimsid', 100)->after('email')->nullable();
            $table->string('ftid', 100)->after('pimsid')->nullable();
        });

        $permissions = [
            'users_upload'
        ];


        foreach ($permissions as $permission) {
                Permission::create(['name' => $permission]);
        }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}

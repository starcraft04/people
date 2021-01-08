<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class CreateConsultingPricing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consulting_pricing', function (Blueprint $table) {
            $table->increments('id');
            $table->string('country', 50);
            $table->string('role', 50);
            $table->float('unit_cost')->default(0);
            $table->float('unit_price')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        DB::statement('ALTER TABLE `consulting_pricing` ADD UNIQUE( `country`, `role`);');

        $permissions = [
            'consulting_pricing_upload'
        ];


        foreach ($permissions as $permission) {
                Permission::create(['name' => $permission]);
        }

        Schema::table('project_loe_consultant', function (Blueprint $table) {
            $table->float('cost')->after('price')->nullable();
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

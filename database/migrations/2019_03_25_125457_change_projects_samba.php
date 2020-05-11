<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeProjectsSamba extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('pullthru_samba_id', 100)->nullable()->after('gold_order_number');
            $table->string('samba_id', 100)->nullable()->after('gold_order_number');
            $table->string('samba_opportunit_owner', 100)->nullable();
            $table->string('samba_lead_domain', 100)->nullable();
            $table->float('samba_consulting_product_tcv')->nullable();
            $table->float('samba_pullthru_tcv')->nullable();
            $table->string('project_subtype', 100)->nullable()->after('project_type');
            $table->string('samba_stage', 100)->nullable()->after('project_status');
        });
        DB::statement("UPDATE projects SET project_type = 'Project' , project_subtype = 'POC' WHERE project_type = 'POC';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("UPDATE projects SET project_type = 'POC' WHERE project_subtype = 'POC';");
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('pullthru_samba_id');
            $table->dropColumn('samba_id');
            $table->dropColumn('samba_opportunit_owner');
            $table->dropColumn('samba_consulting_product_tcv');
            $table->dropColumn('samba_pullthru_tcv');
            $table->dropColumn('project_subtype');
            $table->dropColumn('samba_stage');
        });
    }
}

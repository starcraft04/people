<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeProjectsFloat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->float('revenue_temp',15,2)->nullable();
            $table->float('samba_consulting_product_tcv_temp',15,2)->nullable();
            $table->float('samba_pullthru_tcv_temp',15,2)->nullable();
        });

        DB::statement("UPDATE projects SET revenue_temp = revenue;");
        DB::statement("UPDATE projects SET samba_consulting_product_tcv_temp = samba_consulting_product_tcv;");
        DB::statement("UPDATE projects SET samba_pullthru_tcv_temp = samba_pullthru_tcv;");

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('revenue');
            $table->dropColumn('samba_consulting_product_tcv');
            $table->dropColumn('samba_pullthru_tcv');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->float('revenue',15,2)->nullable();
            $table->float('samba_consulting_product_tcv',15,2)->nullable();
            $table->float('samba_pullthru_tcv',15,2)->nullable();
        });
        
        DB::statement("UPDATE projects SET revenue = revenue_temp;");
        DB::statement("UPDATE projects SET samba_consulting_product_tcv = samba_consulting_product_tcv_temp;");
        DB::statement("UPDATE projects SET samba_pullthru_tcv = samba_pullthru_tcv_temp;");

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('revenue_temp');
            $table->dropColumn('samba_consulting_product_tcv_temp');
            $table->dropColumn('samba_pullthru_tcv_temp'); 
        });
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

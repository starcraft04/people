<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeCustomersProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->integer('customer_id')->unsigned()->after('customer_name');
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->renameColumn('customer_name', 'name');
        });
        DB::statement('UPDATE projects AS p JOIN customers AS c ON c.name = p.customer_name SET p.customer_id = c.id;');
        DB::statement('ALTER TABLE projects DROP INDEX project_name;');
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('customer_name');
        });
        DB::statement('ALTER TABLE `projects` ADD UNIQUE( `project_name`, `customer_id`);');
        Schema::table('projects', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')
                            ->onDelete('restrict')
                            ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign('projects_customer_id_foreign');
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->string('customer_name', 100)->after('customer_id');
        });
        DB::statement('UPDATE projects AS p JOIN customers AS c ON c.id = p.customer_id SET p.customer_name = c.name;');
        DB::statement('ALTER TABLE projects DROP INDEX project_name;');
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('customer_id');
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->renameColumn('name', 'customer_name');
        });
        DB::statement('ALTER TABLE `projects` ADD UNIQUE( `project_name`, `customer_name`);');
    }
}

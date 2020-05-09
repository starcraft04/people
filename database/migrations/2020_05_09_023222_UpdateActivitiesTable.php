<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities_temp', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->integer('year');
			$table->integer('project_id')->unsigned();
			$table->integer('user_id')->unsigned();
            $table->float('jan_user')->nullable();
            $table->float('jan_otl')->nullable();
            $table->float('feb_user')->nullable();
            $table->float('feb_otl')->nullable();
            $table->float('mar_user')->nullable();
            $table->float('mar_otl')->nullable();
            $table->float('apr_user')->nullable();
            $table->float('apr_otl')->nullable();
            $table->float('may_user')->nullable();
            $table->float('may_otl')->nullable();
            $table->float('jun_user')->nullable();
            $table->float('jun_otl')->nullable();
            $table->float('jul_user')->nullable();
            $table->float('jul_otl')->nullable();
            $table->float('aug_user')->nullable();
            $table->float('aug_otl')->nullable();
            $table->float('sep_user')->nullable();
            $table->float('sep_otl')->nullable();
            $table->float('oct_user')->nullable();
            $table->float('oct_otl')->nullable();
            $table->float('nov_user')->nullable();
            $table->float('nov_otl')->nullable();
            $table->float('dec_user')->nullable();
            $table->float('dec_otl')->nullable();
			$table->timestamp('created_at')->nullable();
			$table->timestamp('updated_at')->nullable();
        });

        DB::statement("
        INSERT INTO `activities_temp`
        (year,project_id,user_id,jan_user,jan_otl,feb_user,feb_otl,mar_user,mar_otl,apr_user,apr_otl,may_user,may_otl,jun_user,jun_otl,
        jul_user,jul_otl,aug_user,aug_otl,sep_user,sep_otl,oct_user,oct_otl,nov_user,nov_otl,dec_user,dec_otl)
        SELECT year,project_id,user_id,
            max(case when month = 1 and from_otl = 0 then task_hour end) as jan_user,
            max(case when month = 1 and from_otl = 1 then task_hour end) as jan_otl,
            max(case when month = 2 and from_otl = 0 then task_hour end) as feb_user,
            max(case when month = 2 and from_otl = 1 then task_hour end) as feb_otl,
            max(case when month = 3 and from_otl = 0 then task_hour end) as mar_user,
            max(case when month = 3 and from_otl = 1 then task_hour end) as mar_otl,
            max(case when month = 4 and from_otl = 0 then task_hour end) as apr_user,
            max(case when month = 4 and from_otl = 1 then task_hour end) as apr_otl,
            max(case when month = 5 and from_otl = 0 then task_hour end) as may_user,
            max(case when month = 5 and from_otl = 1 then task_hour end) as may_otl,
            max(case when month = 6 and from_otl = 0 then task_hour end) as jun_user,
            max(case when month = 6 and from_otl = 1 then task_hour end) as jun_otl,
            max(case when month = 7 and from_otl = 0 then task_hour end) as jul_user,
            max(case when month = 7 and from_otl = 1 then task_hour end) as jul_otl,
            max(case when month = 8 and from_otl = 0 then task_hour end) as aug_user,
            max(case when month = 8 and from_otl = 1 then task_hour end) as aug_otl,
            max(case when month = 9 and from_otl = 0 then task_hour end) as sep_user,
            max(case when month = 9 and from_otl = 1 then task_hour end) as sep_otl,
            max(case when month = 10 and from_otl = 0 then task_hour end) as oct_user,
            max(case when month = 10 and from_otl = 1 then task_hour end) as oct_otl,
            max(case when month = 11 and from_otl = 0 then task_hour end) as nov_user,
            max(case when month = 11 and from_otl = 1 then task_hour end) as nov_otl,
            max(case when month = 12 and from_otl = 0 then task_hour end) as dec_user,
            max(case when month = 12 and from_otl = 1 then task_hour end) as dec_otl
            from activities
            group by year,project_id,user_id;
        ");

        Schema::table('activities', function(Blueprint $table) {
			$table->dropForeign('activities_project_id_foreign');
		});
		Schema::table('activities', function(Blueprint $table) {
			$table->dropForeign('activities_user_id_foreign');
        });
        
        Schema::drop('activities');

        DB::statement("RENAME TABLE `activities_temp` TO `activities`;");

        DB::statement("ALTER TABLE `activities` ADD UNIQUE( `year`, `project_id`, `user_id`);");

        Schema::table('activities', function(Blueprint $table) {
			$table->foreign('project_id')->references('id')->on('projects')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('activities', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
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
        Schema::table('activities', function(Blueprint $table) {
			$table->dropForeign('activities_project_id_foreign');
		});
		Schema::table('activities', function(Blueprint $table) {
			$table->dropForeign('activities_user_id_foreign');
        });
        
        Schema::drop('activities');
    }
}

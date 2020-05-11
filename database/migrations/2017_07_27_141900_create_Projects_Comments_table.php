<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectsCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('projects_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('project_id')->unsigned();
            $table->text('comment');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
        Schema::table('projects_comments', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');
        });
        Schema::table('projects_comments', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');
        });
    }

    public function down()
    {
        Schema::table('projects_comments', function (Blueprint $table) {
            $table->dropForeign('projects_comments_user_id_foreign');
        });
        Schema::table('projects_comments', function (Blueprint $table) {
            $table->dropForeign('projects_comments_project_id_foreign');
        });
        Schema::drop('projects_comments');
    }
}

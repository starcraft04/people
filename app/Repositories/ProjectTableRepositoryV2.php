<?php

namespace App\Repositories;

use Datatables;
use DB;
use Entrust;
use Auth;

class ProjectTableRepositoryV2
{
  // We are going to create 1 temporary table and we need to protect them
  // manke sure you use unset() on the object reference so that it will call destruct and free up memory
  private $table_name_cols;

  // When creating the object, please pass the name of 2 tables that will be created...
  public function __construct($table_name_cols){
    $this->table_name_cols = $table_name_cols;
    $this->create_temp_table_with_months_as_columns($this->table_name_cols);
  }

  public function __destruct() {
    $this->destroy_table($this->table_name_cols);
  }

  public function create_temp_table_with_months_as_columns($table_name_cols){
    $dropTempTables = DB::unprepared(
         DB::raw("
             DROP TABLE IF EXISTS ".$table_name_cols.";
         ")
    );

    $createTempTable = DB::unprepared(DB::raw("
      CREATE TEMPORARY TABLE ".$table_name_cols."
(
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  year INT(10),
  project_id INT(10),
  user_id INT(10),
  jan_user double(8,2) DEFAULT 0,
  jan_otl double(8,2) DEFAULT 0,
  jan_from_otl tinyint(1) DEFAULT 0,
  feb_user double(8,2) DEFAULT 0,
  feb_otl double(8,2) DEFAULT 0,
  feb_from_otl tinyint(1) DEFAULT 0,
  mar_user double(8,2) DEFAULT 0,
  mar_otl double(8,2) DEFAULT 0,
  mar_from_otl tinyint(1) DEFAULT 0,
  apr_user double(8,2) DEFAULT 0,
  apr_otl double(8,2) DEFAULT 0,
  apr_from_otl tinyint(1) DEFAULT 0,
  may_user double(8,2) DEFAULT 0,
  may_otl double(8,2) DEFAULT 0,
  may_from_otl tinyint(1) DEFAULT 0,
  jun_user double(8,2) DEFAULT 0,
  jun_otl double(8,2) DEFAULT 0,
  jun_from_otl tinyint(1) DEFAULT 0,
  jul_user double(8,2) DEFAULT 0,
  jul_otl double(8,2) DEFAULT 0,
  jul_from_otl tinyint(1) DEFAULT 0,
  aug_user double(8,2) DEFAULT 0,
  aug_otl double(8,2) DEFAULT 0,
  aug_from_otl tinyint(1) DEFAULT 0,
  sep_user double(8,2) DEFAULT 0,
  sep_otl double(8,2) DEFAULT 0,
  sep_from_otl tinyint(1) DEFAULT 0,
  oct_user double(8,2) DEFAULT 0,
  oct_otl double(8,2) DEFAULT 0,
  oct_from_otl tinyint(1) DEFAULT 0,
  nov_user double(8,2) DEFAULT 0,
  nov_otl double(8,2) DEFAULT 0,
  nov_from_otl tinyint(1) DEFAULT 0,
  dec_user double(8,2) DEFAULT 0,
  dec_otl double(8,2) DEFAULT 0,
  dec_from_otl tinyint(1) DEFAULT 0
) engine=memory;

ALTER TABLE ".$table_name_cols." ADD UNIQUE( `year`,`project_id`, `user_id`);

INSERT INTO ".$table_name_cols." (`year`,`project_id`,`user_id`) (SELECT `year`,`project_id`,`user_id` FROM `activities` group by `year`,`project_id`,`user_id`);

UPDATE ".$table_name_cols." t, activities a SET t.jan_user=a.task_hour,t.jan_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=0 AND a.month = 1;
UPDATE ".$table_name_cols." t, activities a SET t.jan_otl=a.task_hour,t.jan_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=1 AND a.month = 1;

UPDATE ".$table_name_cols." t, activities a SET t.feb_user=a.task_hour,t.feb_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=0 AND a.month = 2;
UPDATE ".$table_name_cols." t, activities a SET t.feb_otl=a.task_hour,t.feb_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=1 AND a.month = 2;

UPDATE ".$table_name_cols." t, activities a SET t.mar_user=a.task_hour,t.mar_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=0 AND a.month = 3;
UPDATE ".$table_name_cols." t, activities a SET t.mar_otl=a.task_hour,t.mar_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=1 AND a.month = 3;

UPDATE ".$table_name_cols." t, activities a SET t.apr_user=a.task_hour,t.apr_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=0 AND a.month = 4;
UPDATE ".$table_name_cols." t, activities a SET t.apr_otl=a.task_hour,t.apr_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=1 AND a.month = 4;

UPDATE ".$table_name_cols." t, activities a SET t.may_user=a.task_hour,t.may_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=0 AND a.month = 5;
UPDATE ".$table_name_cols." t, activities a SET t.may_otl=a.task_hour,t.may_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=1 AND a.month = 5;

UPDATE ".$table_name_cols." t, activities a SET t.jun_user=a.task_hour,t.jun_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=0 AND a.month = 6;
UPDATE ".$table_name_cols." t, activities a SET t.jun_otl=a.task_hour,t.jun_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=1 AND a.month = 6;

UPDATE ".$table_name_cols." t, activities a SET t.jul_user=a.task_hour,t.jul_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=0 AND a.month = 7;
UPDATE ".$table_name_cols." t, activities a SET t.jul_otl=a.task_hour,t.jul_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=1 AND a.month = 7;

UPDATE ".$table_name_cols." t, activities a SET t.aug_user=a.task_hour,t.aug_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=0 AND a.month = 8;
UPDATE ".$table_name_cols." t, activities a SET t.aug_otl=a.task_hour,t.aug_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=1 AND a.month = 8;

UPDATE ".$table_name_cols." t, activities a SET t.sep_user=a.task_hour,t.sep_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=0 AND a.month = 9;
UPDATE ".$table_name_cols." t, activities a SET t.sep_otl=a.task_hour,t.sep_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=1 AND a.month = 9;

UPDATE ".$table_name_cols." t, activities a SET t.oct_user=a.task_hour,t.oct_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=0 AND a.month = 10;
UPDATE ".$table_name_cols." t, activities a SET t.oct_otl=a.task_hour,t.oct_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=1 AND a.month = 10;

UPDATE ".$table_name_cols." t, activities a SET t.nov_user=a.task_hour,t.nov_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=0 AND a.month = 11;
UPDATE ".$table_name_cols." t, activities a SET t.nov_otl=a.task_hour,t.nov_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=1 AND a.month = 11;

UPDATE ".$table_name_cols." t, activities a SET t.dec_user=a.task_hour,t.dec_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=0 AND a.month = 12;
UPDATE ".$table_name_cols." t, activities a SET t.dec_otl=a.task_hour,t.dec_from_otl=a.from_otl WHERE t.year=a.year AND t.project_id=a.project_id AND t.user_id=a.user_id AND a.from_otl=1 AND a.month = 12;

      "));

      return $createTempTable;
  }
  public function destroy_table($table_name){
    $dropTempTables = DB::unprepared(
         DB::raw("
             DROP TABLE IF EXISTS ".$table_name.";
         ")
    );
  }
}


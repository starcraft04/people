<?php

namespace App\Repositories;

use Datatables;
use DB;
use Entrust;
use Auth;

class ProjectTableRepository
{
  // We are going to create 2 temporary table and we need to protect them
  // manke sure you use unset() on the object reference so that it will call destruct and free up memory
  private $table_name_lines;
  private $table_name_cols;

  // When creating the object, please pass the name of 2 tables that will be created...
  public function __construct($table_name_lines,$table_name_cols){
    $this->table_name_lines = $table_name_lines;
    $this->table_name_cols = $table_name_cols;
    $this->create_temp_table_with_lines($this->table_name_lines);
    $this->create_temp_table_with_months_as_columns($this->table_name_lines,$this->table_name_cols);
  }

  public function __destruct() {
    $this->destroy_table($this->table_name_lines);
    $this->destroy_table($this->table_name_cols);
  }

  public function create_temp_table_with_lines($table_name){
    $dropTempTables = DB::unprepared(
         DB::raw("
             DROP TABLE IF EXISTS ".$table_name.";
         ")
    );

    $createTempTable = DB::unprepared(DB::raw("
      CREATE TEMPORARY TABLE ".$table_name."
      AS (
            SELECT *
            FROM activities AS a4
            WHERE a4.id NOT IN
              (
                SELECT a3.id
                FROM activities AS a3
                INNER JOIN (SELECT * FROM activities AS a1 where a1.from_otl = 1) AS a2
                ON (a3.user_id = a2.user_id AND a3.project_id = a2.project_id AND a3.year = a2.year AND a3.month = a2.month)
                WHERE a3.from_otl = 0
              )
          )
      "));

      return $createTempTable;
  }

  public function create_temp_table_with_months_as_columns($table_name_lines,$table_name_cols){
    $dropTempTables = DB::unprepared(
         DB::raw("
             DROP TABLE IF EXISTS ".$table_name_cols.";
         ")
    );

    $createTempTable = DB::unprepared(DB::raw("
      CREATE TEMPORARY TABLE ".$table_name_cols."
      AS (
            SELECT
                    temp_a.user_id AS user_id,
                    u.name AS user_name,
                    u.employee_type AS user_employee_type,
                    u.domain AS user_domain,
                    uu.manager_id AS manager_id,
                    m.name AS manager_name,
                    temp_a.project_id AS project_id,
                    p.project_name AS project_name,
                    c.name AS customer_name,
                    p.otl_project_code AS otl_project_code,
                    p.meta_activity AS meta_activity,
                    p.project_type AS project_type,
                    p.activity_type AS activity_type,
                    p.project_status AS project_status,
                    p.region AS region,
                    p.country AS country,
                    p.customer_location AS customer_location,
                    p.technology AS technology,
                    p.description AS description,
                    p.comments AS comments,
                    p.LoE_onshore AS LoE_onshore,
                    p.LoE_nearshore AS LoE_nearshore,
                    p.LoE_offshore AS LoE_offshore,
                    p.LoE_contractor AS LoE_contractor,
                    p.gold_order_number AS gold_order_number,
                    p.product_code AS product_code,
                    p.revenue AS revenue,
                    p.win_ratio AS win_ratio,
                    p.estimated_start_date AS estimated_start_date,
                    p.estimated_end_date AS estimated_end_date,
                    temp_a.year AS year,
                    sum(CASE WHEN month = 1 THEN task_hour ELSE 0 END) AS jan_com,
                    sum(CASE WHEN month = 1 THEN temp_a.from_otl ELSE 0 END) AS jan_otl,
                    sum(CASE WHEN month = 2 THEN task_hour ELSE 0 END) AS feb_com,
                    sum(CASE WHEN month = 2 THEN temp_a.from_otl ELSE 0 END) AS feb_otl,
                    sum(CASE WHEN month = 3 THEN task_hour ELSE 0 END) AS mar_com,
                    sum(CASE WHEN month = 3 THEN temp_a.from_otl ELSE 0 END) AS mar_otl,
                    sum(CASE WHEN month = 4 THEN task_hour ELSE 0 END) AS apr_com,
                    sum(CASE WHEN month = 4 THEN temp_a.from_otl ELSE 0 END) AS apr_otl,
                    sum(CASE WHEN month = 5 THEN task_hour ELSE 0 END) AS may_com,
                    sum(CASE WHEN month = 5 THEN temp_a.from_otl ELSE 0 END) AS may_otl,
                    sum(CASE WHEN month = 6 THEN task_hour ELSE 0 END) AS jun_com,
                    sum(CASE WHEN month = 6 THEN temp_a.from_otl ELSE 0 END) AS jun_otl,
                    sum(CASE WHEN month = 7 THEN task_hour ELSE 0 END) AS jul_com,
                    sum(CASE WHEN month = 7 THEN temp_a.from_otl ELSE 0 END) AS jul_otl,
                    sum(CASE WHEN month = 8 THEN task_hour ELSE 0 END) AS aug_com,
                    sum(CASE WHEN month = 8 THEN temp_a.from_otl ELSE 0 END) AS aug_otl,
                    sum(CASE WHEN month = 9 THEN task_hour ELSE 0 END) AS sep_com,
                    sum(CASE WHEN month = 9 THEN temp_a.from_otl ELSE 0 END) AS sep_otl,
                    sum(CASE WHEN month = 10 THEN task_hour ELSE 0 END) AS oct_com,
                    sum(CASE WHEN month = 10 THEN temp_a.from_otl ELSE 0 END) AS oct_otl,
                    sum(CASE WHEN month = 11 THEN task_hour ELSE 0 END) AS nov_com,
                    sum(CASE WHEN month = 11 THEN temp_a.from_otl ELSE 0 END) AS nov_otl,
                    sum(CASE WHEN month = 12 THEN task_hour ELSE 0 END) AS dec_com,
                    sum(CASE WHEN month = 12 THEN temp_a.from_otl ELSE 0 END) AS dec_otl
            FROM ".$table_name_lines." AS temp_a
            LEFT JOIN projects AS p ON p.id = temp_a.project_id
            LEFT JOIN users AS u ON temp_a.user_id = u.id
            LEFT JOIN users_users AS uu ON u.id = uu.user_id
            LEFT JOIN users AS m ON m.id = uu.manager_id
            LEFT JOIN customers AS c ON c.id = p.customer_id
            GROUP BY year,user_id,c.name,p.project_name,p.project_type,p.activity_type,p.project_status

          )
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


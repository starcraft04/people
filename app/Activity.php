<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Activity extends Model {

	protected $table = 'activity';
	public $timestamps = true;
	protected $fillable = array('meta_activity', 'year', 'month', 'project_id', 'task_hour', 'from_otl', 'employee_id');
    
	public function employee()
	{
		return $this->belongsTo('App\Employee','employee_id','id');
	}

	public function project()
	{
		return $this->belongsTo('App\Project','project_id','id');
	}
	public function activityTablePaginate($n)
    {
        return DB::table('activity AS A')
            ->select('A.id AS id','A.year AS year','A.month AS month','A.task_hour AS task_hour','E.name AS employee_name','P.customer_name AS project_customer_name')
            ->join('employee AS E', 'A.employee_id', '=', 'E.id')
            ->join('project AS P', 'A.project_id', '=', 'P.id')
            ->paginate($n);
    }
}
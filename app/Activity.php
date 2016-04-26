<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model {

	protected $table = 'activity';
	public $timestamps = true;
	protected $fillable = array('year', 'month', 'project_id', 'task_hour', 'from_otl', 'employee_id');

	public function employee()
	{
		return $this->belongsTo('App\Employee');
	}

	public function project()
	{
		return $this->belongsTo('App\Project');
	}

}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamTask extends Model {

	protected $table = 'team_task';
	public $timestamps = true;
	protected $fillable = array('name', 'severity', 'begin_date', 'end_date', 'description', 'employee_id', 'project_id');

	public function project()
	{
		return $this->belongsTo('Project');
	}

	public function employee()
	{
		return $this->belongsTo('Employee');
	}

}
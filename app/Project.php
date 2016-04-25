<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {

	protected $table = 'project';
	public $timestamps = true;
	protected $fillable = array('customer_name', 'project_name', 'task_name', 'from_otl', 'project_type', 'task_category', 'meta_activity', 'region', 'country');

	public function activity()
	{
		return $this->hasMany('Activity');
	}

	public function goldOrder()
	{
		return $this->hasMany('GoldOrder');
	}

	public function teamTask()
	{
		return $this->hasMany('TeamTask');
	}

}
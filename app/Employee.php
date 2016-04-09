<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Employee extends Model {

	protected $table = 'employees';
	
	public $timestamps = true;

	public function projects()
	{
		return $this->hasMany('App\Projects');
	}
	public function employee()
	{
		return $this->hasOne('App\Employee','id')->select(['employee_name']);
	}
	
	public function allManagers()
	{
		$managers = DB::table('employees')->select(['id','employee_name'])->orderBy('employee_name')->get();
		$result = Array();
		foreach ($managers as $manager)
		{
			$result[$manager->id] = $manager->employee_name;
		}
		return $result;
	}
	

}
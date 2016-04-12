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
	public function manager()
	{
		return $this->hasOne('App\Employee','id')->select(['name']);
	}
	public function employeeTablePaginate($n)
    {
        return DB::table('employees AS E')
            ->select('E.id AS id','E.name AS name','E.manager_id AS manager_id','E.is_manager AS is_manager','M.name AS manager_name')
            ->join('employees AS M', 'E.manager_id', '=', 'M.id')
            ->paginate($n);
    }
        
	public function getAllManagers()
	{
		$managers = DB::table('employees')->select(['id','name'])->orderBy('name')->where('is_manager','=','1')->get();
		return $managers;
	}
	

}
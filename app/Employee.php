<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Employee extends Model {

	protected $table = 'employee';
	public $timestamps = true;
    protected $fillable = array('name', 'manager_id', 'is_manager', 'from_otl');

	public function activity()
	{
		return $this->hasMany('App\Activity');
	}
	public function manager()
	{
		return $this->hasOne('App\Employee','id');
	}
	public function employeeTablePaginate($n)
    {
        return DB::table('employee AS E')
            ->select('E.id AS id','E.name AS name','E.manager_id AS manager_id','E.is_manager AS is_manager','M.name AS manager_name')
            ->join('employee AS M', 'E.manager_id', '=', 'M.id')
            ->paginate($n);
    }
}
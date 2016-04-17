<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Employee extends Model {

	protected $table = 'employee';
	public $timestamps = true;
    protected $fillable = array('name', 'manager_id', 'is_manager', 'from_otl');
    protected $hidden = ['created_at','updated_at'];

	public function activity()
	{
		return $this->hasMany('App\Activity');
	}
	public function manager()
	{
		return $this->hasOne('App\Employee','id','manager_id');
	}
}
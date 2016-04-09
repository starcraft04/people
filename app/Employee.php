<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model {

	protected $table = 'employees';
	public $timestamps = true;

	public function projects()
	{
		return $this->hasMany('Projects');
	}
	public function manager()
	{
		return $this->hasOne('Employee');
	}

}
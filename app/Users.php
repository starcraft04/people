<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model {

	protected $table = 'users';
	public $timestamps = true;
	protected $fillable = array('name', 'email', 'password', 'admin', 'employee_id');

	public function employee()
	{
		return $this->hasOne('Employee');
	}

}
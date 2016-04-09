<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model {

	protected $table = 'projects';
	public $timestamps = true;

	public function employee()
	{
		return $this->belongsTo('Employee');
	}

}
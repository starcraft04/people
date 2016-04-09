<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activities extends Model {

	protected $table = 'activities';
	public $timestamps = true;

	public function employee()
	{
		return $this->belongsTo('Employee');
	}

	public function projects()
	{
		return $this->belongsTo('Projects');
	}

}
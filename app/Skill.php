<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model {

	protected $table = 'skill';
	public $timestamps = true;
	protected $fillable = array('skill_type', 'skill_category_name', 'skill', 'rank', 'employee_last_assessed', 'from_step', 'employee_id');

	public function employee()
	{
		return $this->belongsTo('Employee');
	}

}
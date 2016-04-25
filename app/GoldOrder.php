<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoldOrder extends Model {

	protected $table = 'gold_order';
	public $timestamps = true;
	protected $fillable = array('project_id', 'number', 'gold_revenue_id');

	public function project()
	{
		return $this->belongsTo('Project');
	}

	public function goldRevenue()
	{
		return $this->hasMany('GoldRevenue');
	}

}
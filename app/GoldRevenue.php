<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoldRevenue extends Model {

	protected $table = 'gold_revenue';
	public $timestamps = true;
	protected $fillable = array('code', 'amount');

	public function goldOrder()
	{
		return $this->belongsTo('GoldOrder');
	}

}
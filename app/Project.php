<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Project extends Model {

	protected $table = 'projects';
	public $timestamps = true;

	public function activities()
	{
		return $this->hasMany('Activities');
	}
	public function projectTablePaginate($n)
    {
        return DB::table('projects AS E')
            ->select('*')
            ->paginate($n);
    }
}
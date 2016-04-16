<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Project extends Model {

	protected $table = 'project';
	public $timestamps = true;
    protected $fillable = array('customer_name', 'project_name', 'task_name', 'from_otl');
    
	public function activity()
	{
		return $this->hasMany('App\Activity');
	}
	public function projectTablePaginate($n)
    {
        return DB::table('project')
            ->select('*')
            ->paginate($n);
    }
    public function getFullNameAttribute()
    {
        return $this->customer_name . "-" . $this->project_name . "-" . $this->task_name;
    }
}
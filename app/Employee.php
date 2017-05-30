<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model 
{

    protected $table = 'employee';
    public $timestamps = true;
    protected $fillable = array('name', 'manager_id', 'is_manager', 'from_otl', 'region', 'country', 'subdomain', 'from_step', 'domain', 'management_code', 'job_role', 'employee_type');

    public function activity()
    {
        return $this->hasMany('Activity');
    }

    public function manager()
    {
        return $this->hasOne('Employee');
    }

    public function skill()
    {
        return $this->hasMany('Skill');
    }

    public function users()
    {
        return $this->belongsTo('Users');
    }

}
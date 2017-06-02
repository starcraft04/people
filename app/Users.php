<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model 
{

    protected $table = 'users';
    public $timestamps = true;
    protected $fillable = array('username', 'email', 'password', 'created_at', 'employee_id', 'updated_at');

    public function employee()
    {
        return $this->hasOne('Employee');
    }

}
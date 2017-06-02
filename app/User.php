<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    public $timestamps = true;
    protected $fillable = [
        'name', 'email', 'created_at', 'employee_id', 'updated_at','password'
      ];
    protected $hidden = [
        'remember_token',
      ];

    public function employee()
    {
        return $this->hasOne('Employee');
    }

}

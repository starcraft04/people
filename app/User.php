<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait; // add this trait to your user model

    protected $table = 'users';
    public $timestamps = true;
    protected $fillable = [
      'name', 'email', 'password', 'created_at', 'is_manager', 'updated_at',
      'from_otl', 'region', 'country', 'domain', 'management_code', 'job_role',
      'employee_type',
      ];
    protected $hidden = [
        'remember_token', 'password',
      ];

    public function activities()
    {
        return $this->hasMany('App\Activity', 'user_id');
    }

    public function managers()
    {
        return $this->belongsToMany('App\User', 'users_users', 'user_id', 'manager_id')->withPivot('manager_type')->withTimestamps();
    }

    public function employees()
    {
        return $this->belongsToMany('App\User', 'users_users', 'manager_id', 'user_id')->withPivot('manager_type')->withTimestamps();
    }

    public function projects()
    {
        return $this->hasMany('App\Project', 'created_by_user_id');
    }

    public function update_password($password, $toDB = false)
    {
        $this->password = bcrypt($password);
        if ($toDB) {
            $this->save();
        }

        return $this;
    }

    public function clusters()
    {
        return $this->hasMany('App\Cluster');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loe extends Model
{
    protected $table = 'project_loe';
    public $timestamps = true;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function user_signoff()
    {
        return $this->belongsTo(\App\User::class, 'signoff_user_id');
    }

    public function project()
    {
        return $this->belongsTo(\App\Project::class, 'project_id');
    }

    public function history()
    {
        return $this->hasMany(\App\LoeHistory::class, 'project_loe_id');
    }
    public function site()
    {
        return $this->hasMany(\App\LoeSite::class, 'project_loe_id');
    }
    public function consultant()
    {
        return $this->hasMany(\App\LoeConsultant::class, 'project_loe_id');
    }
}

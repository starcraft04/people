<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';
    public $timestamps = true;
    protected $fillable = ['year', 'month', 'project_id', 'user_id', 'task_hour', 'from_otl'];

    public function project()
    {
        return $this->belongsTo(\App\Project::class, 'project_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function scopeFromOtl($query)
    {
        return $query->where('from_otl', '=', 1);
    }
}

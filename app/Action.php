<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $table = 'actions';
    public $timestamps = true;
    protected $guarded = ['id'];

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function assigned_user()
    {
        return $this->belongsTo('App\User', 'assigned_user_id');
    }
}

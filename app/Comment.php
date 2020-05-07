<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $table = 'projects_comments';
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

    public function user_summary()
    {
        return $this->belongsTo('App\User', 'user_id')->select(['id', 'name']);
    }

}


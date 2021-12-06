<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourceRequest extends Model
{
    //
    protected $table = 'reources_request';
    public $timestamps = true;
    protected $guarded = ['id'];

    public function project()
    {
        return $this->belongsTo(\App\Project::class, 'project_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }
}

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
        return $this->belongsTo('App\User', 'user_id');
    }

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }
}

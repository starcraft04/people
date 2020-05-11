<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    //
    public $timestamps = false;
    protected $table = 'cluster_user';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function cluster()
    {
        return $this->belongsTo('App\Cluster', 'cluster_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    //
	public $timestamps = false;
    protected $table = 'clusters';
    protected $guarded = ['id'];
    
    public function countries()
    {
        return $this->hasMany('App\Country');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'cluster_user' , 'cluster_id', 'user_id');
    }

}

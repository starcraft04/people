<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $table = 'customers';
    public $timestamps = false;
    protected $fillable = array('name','cluster_owner');

    public function projects()
    {
        return $this->hasMany('App\Project', 'customer_id');
    }

}

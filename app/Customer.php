<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $table = 'customers';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function projects()
    {
        return $this->hasMany(\App\Project::class, 'customer_id');
    }

    public function other_names()
    {
        return $this->hasMany(\App\CustomerOtherName::class, 'customer_id');
    }

}

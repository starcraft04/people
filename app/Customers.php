<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{

    protected $table = 'customers';
    public $timestamps = false;
    protected $fillable = array('customer_name','cluster_owner');

}

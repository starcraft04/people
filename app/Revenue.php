<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{

    protected $table = 'revenues';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function customer()
    {
        return $this->belongsTo(\App\Customer::class, 'customer_id');
    }

}

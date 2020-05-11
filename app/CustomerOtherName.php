<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerOtherName extends Model
{
    protected $table = 'customers_other_names';
    public $timestamps = true;
    protected $fillable = ['customer_id', 'other_name'];

    public function dolphin_name()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }
}

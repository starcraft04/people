<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultingPricing extends Model
{
    protected $table = 'consulting_pricing';
    public $timestamps = true;
    protected $guarded = ['id'];
}

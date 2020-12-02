<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loe extends Model
{
    protected $table = 'project_loe_consultant';
    public $timestamps = true;
    protected $guarded = ['id'];

    public function loe()
    {
        return $this->belongsTo(\App\Loe::class, 'project_loe_id');
    }
}

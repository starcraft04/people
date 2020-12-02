<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoeHistory extends Model
{
    protected $table = 'project_loe_history';
    public $timestamps = true;
    protected $guarded = ['id'];

    public function loe()
    {
        return $this->belongsTo(\App\Loe::class, 'project_loe_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

}

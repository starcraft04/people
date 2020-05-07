<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SambaName extends Model
{

    protected $table = 'samba_names';
    public $timestamps = false;
    protected $fillable = ['samba_name','dolphin_name'];

}

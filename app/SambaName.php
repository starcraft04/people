<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SambaName extends Model
{

    protected $table = 'samba_names';
    public $timestamps = false;
    protected $fillable = array('samba_name','dolphin_name');

}

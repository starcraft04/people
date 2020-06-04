<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SambaUser extends Model
{
    protected $table = 'samba_users';
    public $timestamps = false;
    protected $fillable = ['samba_name', 'dolphin_name'];
}

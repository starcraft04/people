<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSkill extends Model
{

    protected $table = 'skill_user';
    public $timestamps = false;
    protected $guarded = ['id'];

}

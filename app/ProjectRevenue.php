<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectRevenue extends Model
{
    protected $table = 'project_revenues';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [];

    protected $table = "companies";

    public function locations()
    {
        $this->hasMany('App\Location');
    }

    public function recruiters()
    {
        return $this->belongsToMany('App\Recruiter');
    }
}

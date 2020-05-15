<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';

    protected $guarded = [];

    public function recruiters()
    {
       return $this->hasMany('App\Recruiter');
    }
}

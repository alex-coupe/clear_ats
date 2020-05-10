<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    protected $guarded = [];
    protected $table='job_listings';

    public function job_listing()
    {
        return $this->belongsToOne('App\Employer');
    }

    public function applications()
    {
        return $this->hasMany('App\Application');
    }
}

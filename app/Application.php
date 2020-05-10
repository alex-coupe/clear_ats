<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded = [];

    protected $table = "applications";

    public function candidate()
    {
        return $this->belongsToOne('App\Candidate');
    }

    public function job_listing()
    {
        return $this->belongsToOne('App\JobListing');
    }
}

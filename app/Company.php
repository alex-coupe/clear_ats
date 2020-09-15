<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [];

    protected $table = "companies";

    public function company_addresses()
    {
        $this->hasMany('App\CompanyAddress');
    }

    public function recruiters()
    {
        return $this->belongsToMany('App\Recruiter');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyAddress extends Model
{
    protected $table = 'company_addresses';

    protected $guarded = [];

    public function recruiters()
    {
       return $this->hasMany('App\Recruiter');
    }

    public function company()
    {
       return $this->hasOne('App\Company');
    }
}

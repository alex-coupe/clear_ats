<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployerAddress extends Model
{
    protected $guarded = [];
    protected $table = 'employer_addresses';

    public function employer()
    {
        return $this->hasOne('App\Employer');
    }
}

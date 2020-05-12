<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployerContact extends Model
{
    protected $guarded = [];
    protected $table = 'employer_contacts';

    public function employer()
    {
        return $this->hasOne('App\Employer');
    }
}

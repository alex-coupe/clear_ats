<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    protected $guarded = [];
    protected $table = 'employers';

    public function addresses()
    {
        return $this->hasMany('App\EmployerAddress');
    }

    public function contacts()
    {
        return $this->hasMany('App\EmployerContact');
    }
}

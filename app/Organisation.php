<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    protected $guarded = [];

    protected $table = "Organisations";

    public function brands()
    {
        $this->hasMany('App\Brand');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }
}

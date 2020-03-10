<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $guarded = [];

    protected $table = "brands";

    public function locations()
    {
        $this->hasMany('App\Location');
    }

    public function users()
    {
        $this->belongsToMany('App\User');
    }
}

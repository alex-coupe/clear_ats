<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $guarded = [];

    protected $table = "candidates";

    public function applications()
    {
        return $this->belongsToMany('App\Application');
    }
}

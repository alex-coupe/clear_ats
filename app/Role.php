<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];
    
    protected $table = 'roles';

    public function users()
    {
        $this->belongsToMany('App\User');
    }
}

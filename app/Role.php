<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];
    
    protected $table = 'roles';

    public $timestamps = false;

    public function recruiterss()
    {
        return $this->belongsToMany(Recruiter::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'role_permissions');
    }
}

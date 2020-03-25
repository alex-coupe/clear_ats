<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $table = 'permissions';

    public function Roles()
    {
        $this->belongsToMany('App\Role', 'role_permissions', 'permission_id', 'role_id');
    }
}

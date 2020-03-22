<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Airlock\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function brands()
    {
        return $this->belongsToMany('App\Brand', 'brands_users', 'user_id', 'brand_id');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'user_roles', 'user_id', 'role_id');
    }

    public function location()
    {
        return $this->hasOne('App\Location', 'id', 'location_id');
    }

    public function organisation()
    {
        return $this->hasOne('App\Organisation', 'id', 'organisation_id');
    }
}

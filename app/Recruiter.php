<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Airlock\HasApiTokens;
use App\Permission;


class Recruiter extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $table="recruiters";

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

    public function company()
    {
        return $this->belongsToOne('App\Company');
    }

    public function companyAddress()
    {
        return $this->hasOne('App\CompanyAddress', 'id', 'company_address_id');
    }

    public function role()
    {
        return $this->hasOne('App\Role', 'id', 'role_id');
    }

    public static function GetPermissions()
    {
        if (auth()->user()) {
            return Permission::whereHas('roles', function($query) {
                $query->where('roles.id', auth()->user()->role_id);
            })->get();
        }
    }

    
}

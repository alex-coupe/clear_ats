<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Permission;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker) {

    $permissions = ['Allow Create Company', 'Allow Delete Company', 'Allow Edit Company', 
    'Allow Access To All Companies', 'Allow Access To Specific Company', 'Allow Create Location',
    'Allow Delete Location', 'Allow Edit Location', 'Allow Access To All Locations', 
    'Allow Access To Specific Location', 'Allow Create Role', 'Allow Delete Role', 'Allow Edit Role',
    'Allow Access To All Roles', 'Allow Access To My Role', 'Allow Access To All Recruiters', 'Allow Access To Recruiter',
    'Allow Update Recruiter', 'Allow Delete Recruiter'];
    //Add more as we go
    return [
       'description' => $faker->randomElement($permissions),
        'active' => $faker->boolean
    ];
});

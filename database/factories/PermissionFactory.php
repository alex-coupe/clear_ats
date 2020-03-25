<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Permission;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker) {

    $permissions = ['Allow Create Brand', 'Allow Delete Brand', 'Allow Edit Brand', 
    'Allow Access To All Brands', 'All Access To User Brand', 'Allow Create Location',
    'Allow Delete Location', 'Allow Edit Location', 'Allow Access To All Locations', 
    'Allow Access To My Location', 'Allow Create Role', 'Allow Delete Role', 'Allow Edit Role',
    'Allow Access To All Roles', 'Allow Access To My Role'];
    //Add more as we go
    return [
       'description' => $faker->randomElement($permissions),
        'active' => $faker->boolean
    ];
});

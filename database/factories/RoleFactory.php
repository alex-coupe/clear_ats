<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    return [
       'role_name' => $faker->randomElement(array('Admin', 'Manager', 'Recruiter')),
       'company_id' => $faker->numberBetween(1,5)
    ];
});

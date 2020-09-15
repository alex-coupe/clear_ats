<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employer;
use Faker\Generator as Faker;

$factory->define(Employer::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'telephone' => $faker->phoneNumber,
        'email' => $faker->email,
        'website' => $faker->url,
        'industry' => 'Accountancy',
        'size' => $faker->numberBetween(1,500).' employees',
        'creating_recruiter_id' =>  $faker->numberBetween(0,10)
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\EmployerAddress;
use Faker\Generator as Faker;

$factory->define(EmployerAddress::class, function (Faker $faker) {
    return [
        'employer_id' => $faker->numberBetween(0,10),
        'line_one' => $faker->streetAddress,
        'line_two' => $faker->secondaryAddress,
        'city' => $faker->city,
        'state' => 'Kent',
        'post_code' => $faker->postcode
    ];
});

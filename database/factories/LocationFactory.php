<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Location;
use Faker\Generator as Faker;

$factory->define(Location::class, function (Faker $faker) {
    return [
        'name' => $faker->cityPrefix,
        'address_one' => $faker->streetAddress,
        'address_two' => $faker->secondaryAddress,
        'city' => $faker->city,
        'state' => $faker->state,
        'post_code' => $faker->postcode
    ];
});

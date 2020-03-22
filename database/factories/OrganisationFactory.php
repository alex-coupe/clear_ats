<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Organisation;
use Faker\Generator as Faker;

$factory->define(Organisation::class, function (Faker $faker) {
    return [
       'name' => $faker->company,
        'address_one' => $faker->streetAddress,
        'address_two' => $faker->secondaryAddress,
        'city' => $faker->city,
        'state' => $faker->county,
        'post_code' => $faker->postcode,
        'telephone' => $faker->phoneNumber,
        'email' => $faker->safeEmail,
        'website' => $faker->url,
        'trading_name' => $faker->company,
        'started_trading' => $faker->date
    ];
});

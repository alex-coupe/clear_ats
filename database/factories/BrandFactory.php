<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Brand;
use Faker\Generator as Faker;

$factory->define(Brand::class, function (Faker $faker) {
    return [
        'brand_name' => $faker->company,
        'location_id' => $faker->numberBetween(0,5),
        'telephone' => $faker->phoneNumber,
        'email' => $faker->safeEmail,
        'website' => $faker->url
    ];
});

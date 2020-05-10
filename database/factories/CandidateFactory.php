<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Candidate;
use Faker\Generator as Faker;

$factory->define(Candidate::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'email' => $faker->email,
        'last_name' => $faker->lastName,
        'cv_path' => $faker->firstName.$faker->lastName.'cv.doc',
        'cover_path' => $faker->firstName.$faker->lastName.'cover_letter.doc',
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Application;
use Faker\Generator as Faker;

$factory->define(Application::class, function (Faker $faker) {
    return [
        'candidate_id' => $faker->numberBetween(1,10),
        'job_listing_id' => $faker->numberBetween(1,10),
        'status_id' => $faker->numberBetween(0,6),
        'cv_path' => $faker->firstName.$faker->lastName.'cv.doc',
    ];
});

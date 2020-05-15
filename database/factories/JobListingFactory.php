<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\JobListing;
use Faker\Generator as Faker;

$factory->define(JobListing::class, function (Faker $faker) {
    return [
        'employer_ref' => $faker->randomNumber,
        'recruiter_ref' => $faker->randomNumber,
        'job_title' => $faker->jobTitle,
        'remuneration' => '£35,000',
        'work_pattern' => 'Mon-Fri 09:00 - 17:00',
        'job_description' => $faker->realText,
        'employer_location_id' => $faker->numberBetween(0,10),
        'expiry_date' => $faker->dateTimeBetween($startDate = '3 weeks', $endDate = '8 weeks', $timezone = null),     
        'job_description_url' => $faker->url
    ];
});

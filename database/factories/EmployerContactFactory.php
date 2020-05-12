<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\EmployerContact;
use Faker\Generator as Faker;

$factory->define(EmployerContact::class, function (Faker $faker) {
    return [
        'employer_id' => $faker->numberBetween(0,10),
        'name' => $faker->name,
        'telephone' => $faker->phoneNumber,
        'mobile' => $faker->e164PhoneNumber,
        'email' => $faker->email,
        'job_title' => $faker->jobTitle
    ];
});

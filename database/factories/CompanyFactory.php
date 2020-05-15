<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'company_name' => $faker->company,
        'company_address_id' => $faker->numberBetween(0,5),
        'telephone' => '01304614719',
        'email' => $faker->safeEmail,
        'website' => $faker->url
    ];
});

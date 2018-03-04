<?php

use Faker\Generator as Faker;

use App\Profile;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'first_name' => $faker->name,
        'last_name' => $faker->last_name,
        // 'address' =>
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(App\Address::class, function (Faker $faker) {
    return [
        'description' => $faker->address,
        'city_id' => $faker->numberBetween(1, 18),
    ];
});

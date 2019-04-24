<?php

use Faker\Generator as Faker;

$factory->define(App\BranchOffice::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'abbreviation' => $faker->randomLetter,
        'address_id' => $faker->unique()->numberBetween(1, 18),
    ];
});

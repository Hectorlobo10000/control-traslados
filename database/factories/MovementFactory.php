<?php

use Faker\Generator as Faker;

$factory->define(App\Movement::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'abbreviation' => $faker->unique()->randomLetter,
    ];
});

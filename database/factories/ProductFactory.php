<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'code' => $faker->ean13,
        'description' => $faker->text(50),
        'enable' => true,
    ];
});

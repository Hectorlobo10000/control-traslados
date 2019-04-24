<?php

use Faker\Generator as Faker;

$factory->define(App\Inventory::class, function (Faker $faker) {
    return [
        'product_id' => $faker->numberBetween(1, 20),
        'movement_id' => 1,
        'branch_office_id' => $faker->numberBetween(1, 18),
        'balance' => $faker->randomFloat(2, 100, 1000),
    ];
});

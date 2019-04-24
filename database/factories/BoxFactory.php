<?php

use Faker\Generator as Faker;

$factory->define(App\Box::class, function (Faker $faker) {
    return [
        'code' => $faker->ean13,
        'box_state_id' => 1,
    ];
});

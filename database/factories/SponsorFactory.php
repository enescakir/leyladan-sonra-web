<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Sponsor::class, function (Faker $faker) {
    return [
        'name'  => $faker->company(),
        'link'   => $faker->url(),
        'order' => $faker->numberBetween(0, 10)
    ];
});
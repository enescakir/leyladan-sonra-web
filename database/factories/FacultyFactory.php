<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Models\Faculty::class, function (Faker $faker) {
    $code = $faker->randomElement(citiesToSelect(true)->keys());
    $startDate = $faker->optional($weight = 0.60)->dateTimeBetween($startDate = '-3 year', $endDate = 'now');
    return [
        'name'       => ($name = $faker->unique()->city()),
        'slug'       => str_slug(remove_turkish($name)),
        'latitude'   => $faker->latitude,
        'longitude'  => $faker->longitude,
        'address'    => $faker->address,
        'city'       => citiesToSelect(true)[$code],
        'code'       => $code,
        'started_at' => $startDate
            ? Carbon::instance($startDate)->format('d.m.Y')
            : null
    ];
});


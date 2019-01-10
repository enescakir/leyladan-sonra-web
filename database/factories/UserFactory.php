<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'first_name'  => $faker->firstName,
        'last_name'   => $faker->lastName,
        'email'       => $faker->unique()->safeEmail(),
        'password'    => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'faculty_id'  => optional(\App\Models\Faculty::inRandomOrder()->first())->id,
        'gender'      => $faker->randomElement(['Kadın', 'Erkek']),
        'birthday'    => Carbon::instance($faker->dateTimeBetween($startDate = '-30 year', $endDate = '-20 year'))
                               ->format('d.m.Y'),
        'mobile'      => $faker->tollFreePhoneNumber,
        'year'        => $faker->numberBetween(0, 6),
        'approved_at' => $faker->optional($weight = 0.60)->dateTimeBetween($startDate = '-3 year', $endDate = 'now'),
    ];
});

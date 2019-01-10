<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Diagnosis::class, function (Faker $faker) {
    return [
        'name' => ($name = title_case_turkish($faker->word())),
        'desc' => $faker->paragraph,
    ];
});

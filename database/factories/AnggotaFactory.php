<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Anggota;
use Faker\Generator as Faker;

$factory->define(Anggota::class, function (Faker $faker) {
    return [
        'id_anggota' => 'MBR' . $faker->numberBetween(1000, 9000),
        'nama' => $faker->name(),
        'email' => $faker->safeEmail(),
        'status' => $faker->randomElement(['Blacklist', 'Active']),
    ];
});

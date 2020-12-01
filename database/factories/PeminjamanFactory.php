<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'id_peminjaman' => $faker->name,
        'peminjam' => $faker->name(),
        'tgl_peminjaman' => date('Y-m-d', 'now'),
        'status' => $faker->randomElement(['Dipinjam', ''])
    ];
});

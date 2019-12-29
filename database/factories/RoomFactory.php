<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Room;
use Faker\Generator as Faker;

$factory->define(Room::class, function (Faker $faker) {
    return [
        'number' => $faker->numberBetween(1, 600),
        'building' => array_rand(\App\Http\Utilities\Buildings::all()),
        'owner_id' => factory(App\User::class)
    ];
});

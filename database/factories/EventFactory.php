<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Room;
use App\Event;
use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    return [
        'owner_id' => factory(App\User::class),
        'room_id' => factory(App\Room::class),
        'type' => 'cancel',
        'date' => $faker->date(),
        'starts_at' => $faker->time(),
        'ends_at' => $faker->time()
    ];
});

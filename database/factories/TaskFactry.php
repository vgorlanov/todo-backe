<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'user_id' => mt_rand(1, 10),
        'project_id' => mt_rand(0, 50),
        'title'   => $faker->text(mt_rand(10, 25)),
        'body'    => $faker->text,
        'done'    => mt_rand(0, 1),
        'date'    => $faker->dateTime(),
    ];
});

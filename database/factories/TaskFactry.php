<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'user_id' => random_int(1, 10),
        'project_id' => random_int(0, 50),
        'title'   => $faker->text(random_int(10, 25)),
        'body'    => $faker->text,
        'done'    => random_int(0, 1),
        'date'    => $faker->dateTime(),
    ];
});

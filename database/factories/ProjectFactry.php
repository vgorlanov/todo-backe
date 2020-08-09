<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'title' => $faker->text(mt_rand(10, 25)),
        'user_id' => mt_rand(1, 10),
    ];
});

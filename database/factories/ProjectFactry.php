<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'title' => $faker->text(random_int(10, 25)),
        'user_id' => random_int(1, 10),
    ];
});

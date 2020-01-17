<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Answer::class, function ($faker) {
    return [
        'text' => $faker->text(20)
    ];
});

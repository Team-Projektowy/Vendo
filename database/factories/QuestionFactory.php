<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Question::class, function (Faker $faker) {
    $categories = App\Category::pluck('id')->toArray();
    return [
        'text' => $faker->text(50),
        'language' => $faker->randomElement(array('en', 'pl')),
        'category' => $faker->randomElement($categories),
        'answerA' => $faker->text(10),
        'answerB' => $faker->text(10),
        'answerC' => $faker->text(10),
        'answerD' => $faker->text(10),
        'correctAnswer' => $faker->numberBetween(0, 3),
        'added_by_user' => function () {
            return factory(App\User::class)->create()->id;
        }
    ];
});
